<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $bills = Bill::where('user_id', $userId)->where('is_paid', false)->orderBy('id', 'desc')->take(5)->get();
        $savings = Saving::where('user_id', $userId)->where('status', false)->orderBy('id', 'desc')->paginate(3);
        return view('index', compact('bills', 'savings'));
    }

    public function getChartData()
    {
        $user = auth()->user();

        // Data Hutang per bulan (aktif dan lunas)
        $monthlyDebts = Bill::where('user_id', $user->id)
            ->selectRaw('MONTH(created_at) as month,
                        SUM(CASE WHEN is_paid = 0 THEN amount ELSE 0 END) as active_debt,
                        SUM(CASE WHEN is_paid = 1 THEN amount ELSE 0 END) as paid_debt')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data untuk chart hutang
        $debtData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'active' => array_fill(0, 12, 0),
            'paid' => array_fill(0, 12, 0)
        ];

        foreach ($monthlyDebts as $debt) {
            $monthIndex = $debt->month - 1;
            $debtData['active'][$monthIndex] = $debt->active_debt;
            $debtData['paid'][$monthIndex] = $debt->paid_debt;
        }

        // Data Tabungan
        $savings = Saving::where('user_id', $user->id)->get();

        return response()->json([
            'debt' => $debtData,
            'savings' => $savings
        ]);
    }


    public function bills()
    {
        $userId = auth()->id();
        $bills = Bill::where('user_id', $userId)->where('is_paid', false)->orderBy('id', 'desc')->paginate(8);
        $paids = Bill::where('user_id', $userId)->where('is_paid', true)->orderBy('id', 'desc')->paginate(8);

        return view('bills', compact('bills', 'paids'));
    }

    public function bill_store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'amount' => 'required|string',
            'description' => 'nullable|string|max:500',
        ]);

        $numericAmount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

        // Simpan data ke database
        $bill = new Bill();
        $bill->user_id = auth()->id();
        $bill->item = $validated['item'];
        $bill->amount = $numericAmount;
        $bill->description = $validated['description'];
        $bill->is_paid = false;
        $bill->save();

        // Redirect dengan pesan sukses
        return redirect()->route('bills')->with('success', 'Hutang berhasil ditambahkan!');
    }

    public function bill_update(Request $request, Bill $bill)
    {
        // Validasi input
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'amount' => 'required|string',
            'description' => 'nullable|string|max:500',
            'is_paid' => 'required|boolean'
        ]);

        // Konversi format Rupiah ke numerik
        $numericAmount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

        // Update data
        $bill->update([
            'item' => $validated['item'],
            'amount' => $numericAmount,
            'description' => $validated['description'],
            'is_paid' => $validated['is_paid'],
            'updated_at' => $validated['is_paid'] ? now() : $bill->updated_at
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('bills')->with('success', 'Hutang berhasil diperbarui!');
    }

    public function bill_paid(Bill $bill)
    {
        if (!$bill->is_paid) {
            $bill->is_paid = true;
            $bill->updated_at = now();
            $bill->save();

            return redirect()->back()->with('success', 'Selamat kamu telah mengurangi dosa kamu');
        }

        return redirect()->back()->with('error', 'Maaf dosa kamu perlu dilihat lagi oleh developernya yah!');
    }

    public function bill_destroy(Bill $bill)
    {
        try {
            if ($bill->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus hutang ini.');
            }

            $bill->delete();

            return redirect()->route('bills')->with('success', 'Hutang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus hutang: ' . $e->getMessage());
        }
    }

    public function savings()
    {
        $userId = Auth::user()->id;
        $savings = Saving::where('user_id', $userId)->orderBy('id', 'desc')->paginate(10);
        return view('savings', compact('savings'));
    }

    public function saving_store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target' => 'required|string',
            'target_date' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string|max:500',
        ]);

        // Konversi format Rupiah ke numerik
        $numericTarget = (int) preg_replace('/[^0-9]/', '', $validated['target']);

        // Simpan data ke database
        $saving = new Saving();
        $saving->name = $validated['name'];
        $saving->user_id = auth()->id(); // Mengambil ID user yang sedang login
        $saving->target = $numericTarget;
        $saving->saving = 0; // Default 0 karena baru dibuat
        $saving->target_date = $validated['target_date'];
        $saving->description = $validated['description'] ?? null;
        $saving->status = false; // Default false karena baru dibuat
        $saving->save();

        // Pengecekan status (meskipun baru dibuat, mungkin saja langsung memenuhi target)
        if ($saving->saving >= $saving->target) {
            $saving->status = true;
            $saving->save();
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Tabungan berhasil dibuat!');
    }

    public function saving_update(Saving $saving, Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target' => 'required|string',
            'target_date' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string|max:500',
        ]);

        // Konversi format Rupiah ke numerik
        $numericTarget = (int) preg_replace('/[^0-9]/', '', $validated['target']);

        // Update data di database
        $saving->name = $validated['name'];
        $saving->target = $numericTarget;
        $saving->target_date = $validated['target_date'];
        $saving->description = $validated['description'] ?? null;

        // Jika target sudah tercapai, pertahankan status true
        // Jika belum, set status berdasarkan kondisi terbaru
        if ($saving->status && $saving->saving >= $numericTarget) {
            // Tetap true jika sebelumnya sudah tercapai
            $saving->status = true;
        } else {
            // Update status berdasarkan perbandingan saving vs target baru
            $saving->status = $saving->saving >= $numericTarget;
        }

        $saving->save();

        // Cek jika status berubah dari false ke true
        if ($saving->wasChanged('status') && $saving->status) {
            return redirect()->back()->with([
                'success' => 'Tabungan berhasil diperbarui!',
                'congrats' => 'Selamat! Tabungan "' . $saving->name . '" telah mencapai target! 🎉'
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Tabungan berhasil diperbarui!');
    }

    public function saving_deposit(Request $request, Saving $saving)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'date' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:500',
        ]);

        // Buat transaksi deposit
        $transaction = $saving->transactions()->create([
            'amount' => $validated['amount'],
            'type' => 'deposit',
            'note' => $validated['description'] ?? null,
            'created_at' => $validated['date']
        ]);

        // Update total saving
        $saving->increment('saving', $validated['amount']);

        // Update status jika target tercapai
        if ($saving->saving >= $saving->target) {
            $saving->update(['status' => true]);
        }

        // Cek jika status berubah
        if ($saving->wasChanged('status') && $saving->status) {
            return redirect()->back()->with([
                'success' => 'Deposit berhasil ditambahkan!',
                'congrats' => 'Selamat! Tabungan "' . $saving->name . '" telah mencapai target! 🎉'
            ]);
        }

        return redirect()->back()->with('success', 'Deposit berhasil ditambahkan!');
    }

    public function saving_withdrawal(Request $request, Saving $saving)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($saving) {
                    if ($value > $saving->saving) {
                        $fail('Jumlah penarikan melebihi saldo yang tersedia.');
                    }
                }
            ],
            'date' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Buat transaksi withdrawal
            $transaction = $saving->transactions()->create([
                'amount' => $validated['amount'],
                'type' => 'withdrawal',
                'note' => $validated['description'] ?? null,
                'created_at' => $validated['date']
            ]);

            // Update total saving
            $saving->decrement('saving', $validated['amount']);

            // Update status jika penarikan membuat saldo di bawah target
            $saving->update([
                'status' => $saving->saving >= $saving->target
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Penarikan berhasil dilakukan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal melakukan penarikan: '.$e->getMessage());
        }
    }

    public function saving_destroy(Saving $saving)
    {
        if ($saving->user_id != auth()->id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak bisa menghapus celengan ini');
        }

        $saving->delete();

        return redirect()->route('savings')
            ->with('success', 'Celengan "'.$saving->name.'" berhasil dihapus');
    }

    public function getStatus(Saving $saving)
    {
        return response()->json([
            'saving' => $saving->saving,
            'target' => $saving->target
        ]);
    }


    public function setting()
    {
        $user = auth()->user();
        return view('settings', compact('user'));
    }

    public function profile_update(Request $request)
    {
        $user = User::find(auth()->id());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:M,F',
            'birthdate' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::delete('public/'.$user->photo);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')
                ->store('profile-photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Update data user
        foreach ($validated as $key => $value) {
            $user->$key = $value;
        }
        $user->save();

        return redirect()->route('setting')
            ->with('success', 'Profil berhasil diperbarui');
    }
}

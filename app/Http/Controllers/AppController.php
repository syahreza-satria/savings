<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $bills = Bill::where('user_id', $userId)->where('is_paid', false)->orderBy('id', 'desc')->take(5)->get();
        $savings = Saving::where('user_id', $userId)->orderBy('id', 'desc')->paginate(3);
        return view('index', compact('bills', 'savings'));
    }

    public function bills()
    {
        $userId = auth()->id();
        $bills = Bill::where('user_id', $userId)->where('is_paid', false)->orderBy('id', 'desc')->paginate(8);
        $paids = Bill::where('is_paid', true)->orderBy('id', 'desc')->paginate(8);

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
        ]);

        // Konversi format Rupiah ke numerik
        $numericAmount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

        // Update data
        $bill->item = $validated['item'];
        $bill->amount = $numericAmount;
        $bill->description = $validated['description'];
        $bill->save();

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

    public function savings()
    {
        $savings = Saving::where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(10);
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
}

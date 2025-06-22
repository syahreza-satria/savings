<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DarkModeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'dark_mode' => 'required|boolean'
        ]);

        // Simpan preferensi di session
        session(['dark_mode' => $request->dark_mode]);

        return response()->json(['success' => true]);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name'    => Setting::get('store_name', 'IGAKERTA BOOK STORE'),
            'store_email'   => Setting::get('store_email', 'admin@igakerta.com'),
            'store_phone'   => Setting::get('store_phone', '081234567890'),
            'store_address' => Setting::get('store_address', 'Jl. Merdeka No. 123, Banten'),
            'footer_text'   => Setting::get('footer_text', 'IGAKERTA Publisher. All rights reserved.'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name'    => 'required|string|max:255',
            'store_email'   => 'required|email|max:255',
            'store_phone'   => 'required|string|max:20',
            'store_address' => 'nullable|string',
            'footer_text'   => 'nullable|string',
        ]);

        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
}

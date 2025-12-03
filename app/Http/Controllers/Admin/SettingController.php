<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => 'required|string|max:20',
        ]);

        Setting::set('whatsapp_number', $validated['whatsapp_number']);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}

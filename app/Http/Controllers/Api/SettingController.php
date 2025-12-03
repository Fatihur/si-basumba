<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function getWhatsapp()
    {
        return response()->json([
            'success' => true,
            'whatsapp_number' => Setting::get('whatsapp_number', '6281234567890'),
        ]);
    }
}

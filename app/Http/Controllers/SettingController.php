<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function update($key, Request $request)
    {

        try {
            $setting = \App\Models\Setting::where('key', $key)->first();
            $setting->value = $request->value;
            $setting->save();
            return back()->with('success', 'Успешно обновлено');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ошибка обновления');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $data['setting']  = Setting::first();
        return view('setting', $data);
    }

    public function update(Request $request)
    {
        if ($request->hasFile('logo')) {
        }

        $setting = Setting::first();
        $setting->update($request->all());
        return redirect(route('setting.index'))->with('message', 'Update Berhasil');
    }
}

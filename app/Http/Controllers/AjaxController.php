<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokterPoliklinik;
use App\User;

class AjaxController extends Controller
{
    public function dropdownDokterBerdasarkanPoliklinik(Request $request)
    {
        $poliklinik = DokterPoliklinik::where('poliklinik_id', $request->poliklinik)->pluck('user_id');
        $user       = User::where('role', 'dokter')->whereIn('id', $poliklinik)->pluck('name', 'id');
        return \Form::select('dokter_id', $user, null, ['class'=>'form-control']);
    }
}

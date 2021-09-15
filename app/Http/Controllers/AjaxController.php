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
        return \Form::select('dokter_id', $user, null, ['class' => 'form-control']);
    }

    // pencarian nama desa dengan element select2
    public function select2Desa()
    {
        $data = \DB::table('view_wilayah_administratif_indonesia')
                ->select('village_id', \DB::raw('CONCAT(village_name, ", ", district_name,", ", regency_name, ", ",province_name) AS village_name'))
                ->where('village_name', 'like', "%".$request->q."%")
                ->limit(20)
                ->get();
        return response()->json($data);
    }
}

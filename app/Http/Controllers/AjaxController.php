<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokterPoliklinik;
use App\Models\JadwalPraktek;
use App\Models\PurchaseOrderDetail;
use App\Models\PermintaanBarangInternalDetail;
use App\User;
use App\Models\Pasien;

class AjaxController extends Controller
{
    public function dropdownDokterBerdasarkanPoliklinik(Request $request)
    {
        $user = JadwalPraktek::with('user')->where('poliklinik_id', $request->poliklinik)
            ->where('hari', date('l'))
            ->get()
            ->pluck('user.name', 'user.id');
        return \Form::select('dokter_id', $user, null, ['class' => 'form-control']);
    }

    // pencarian nama desa dengan element select2
    public function select2Desa(Request $request)
    {
        $data = \DB::table('view_wilayah_administratif_indonesia')
            ->select('village_id', \DB::raw('CONCAT(village_name, ", ", district_name,", ", regency_name, ", ",province_name) AS village_name'))
            ->where('village_name', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Pasien(Request $request)
    {
        $data = \DB::table('pasien')
            ->select('id', 'nama')
            ->where('nama', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }


    public function select2Barang(Request $request)
    {
        $data = \DB::table('barang')
            ->select('id', 'nama_barang', 'harga')
            ->where('nama_barang', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }


    public function pasien(Request $request)
    {
        return Pasien::where('id', $request->pasien_id)->first();
    }

    public function purchaseOrderEditTable(Request $request)
    {
        if ($request->name !== null && $request->value !== null) {
            PurchaseOrderDetail::find($request->pk)->update([$request->name => $request->value]);

            if ($request->name === 'harga') {
                $request['value'] = 'Rp. ' . number_format($request->value, 0, ',', '.');
            }
            $request['status'] = true;
            $request['message'] = 'Data berhasil diubah';
            return $request->all();
        }

        $request['status'] = false;
        $request['message'] = 'Tidak ada data yg terubah';
        return $request->all();
    }

    public function permintaanBarangDetailEditable(Request $request)
    {
        $permintaanBarangDetail = PermintaanBarangInternalDetail::find($request->pk);
        $request['oldValue'] = $permintaanBarangDetail->jumlah_diterima;
        $permintaanBarangDetail->update([$request->name => $request->value]);
        
        return $request->all();
    }

    public function select2User(Request $request)
    {
        $data = \DB::table('users')
            ->select('id', 'name')
            ->where('name', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokterPoliklinik;
use App\Models\JadwalPraktek;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\PermintaanBarangInternalDetail;
use App\User;
use App\Models\Pasien;
use App\Models\Pegawai;

class AjaxController extends Controller
{
    public function dropdownDokterBerdasarkanPoliklinik(Request $request)
    {
        $user = JadwalPraktek::with('user')->where('poliklinik_id', $request->poliklinik)
            ->where('hari', date('l'))
            ->get();

        $dokter = [];
        foreach ($user as $row) {
            $dokter[$row->user_id] = $row->user->name;
        }
        $dokter[0] = 'Dokter Pegganti';
        return \Form::select('dokter_id', $dokter, null, ['class' => 'form-control dokter', 'onChange' => 'dokterPegganti()']);
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

    public function select2Indikator(Request $request)
    {
        $data = \DB::table('indikator')
            ->select('id', 'nama_indikator')
            ->where('nama_indikator', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Pendaftaran(Request $request)
    {
        $data = \DB::table('pendaftaran')
            ->select('id', 'kode')
            ->where('kode', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Tindakan(Request $request)
    {
        $data = \DB::table('tindakan')
            ->select('id', 'kode', 'tindakan')
            ->where('tindakan', 'like', "%" . $request->q . "%")
            ->orWhere('kode', 'like', '%' . $request->q . '%')
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2ICD(Request $request)
    {
        $data = \DB::table('tbm_icd')
            ->select('id', 'indonesia')
            ->where('indonesia', 'like', "%" . $request->q . "%")
            ->orWhere('kode', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function pasien(Request $request)
    {
        return Pasien::where('id', $request->pasien_id)->first();
    }

    public function user(Request $request)
    {
        $pegawai = Pegawai::findOrFail($request->pegawai_id);
        return User::where('id', $pegawai->user_id)->first();
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
    
    public function indikatorEditable(Request $request)
    {
        if ($request->name !== null && $request->value !== null) {
            IndikatorPemeriksaanLab::find($request->pk)->update([$request->name => $request->value]);
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

    public function approvalItemPurchaseOrder(Request $request)
    {
        $item = PurchaseOrderDetail::findOrFail($request->id);
        $item->update($request->only('catatan', 'approval'));
        $purchase_order = \DB::select("select sum(harga*qty) as total from purchase_order_detail where approval=1
        and purchase_order_id=" . $item->purchase_order_id);

        return response()->json(
            [
                'message'   =>  'update sukses',
                'total'     =>  convert_rupiah($purchase_order[0]->total)
            ]
        );
    }

    public function dropdownDokter(Request $request)
    {
        $dokter = User::where('role', 'dokter')->pluck('name', 'id');
        return \Form::select('dokter_pengganti', $dokter, null, ['class' => 'form-control']);
    }

    // pencarian nama desa dengan element select2
    public function select2Perusahaan(Request $request)
    {
        $data = \DB::table('perusahaan_asuransi')
            ->select('id', 'nama_perusahaan')
            ->where('nama_perusahaan', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }
}

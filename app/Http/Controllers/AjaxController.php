<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokterPoliklinik;
use App\Models\JadwalPraktek;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\HasilPemeriksaanLab;
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
            ->where('nama_barang', 'like', "%" . $request->q . "%");

        // if ($request->has('pelayanan')) {
        //     if (strtoupper($request->pelayanan) == 'BPJS') {
        //         $data = $data->where('pelayanan', 'bpjs');
        //     }
        // }

        if (\session('lock_bpjs') != null) {
            if (\session('lock_bpjs') == 'yes') {
                $data = $data->where('pelayanan', 'bpjs');
            }
        }
        $data = $data->limit(20)->get();
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

    public function select2Dokter(Request $request)
    {
        $data = \DB::table('users')
            ->select('id', 'name')
            ->where('role', 'dokter')
            ->where('name', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Poliklinik(Request $request)
    {
        $data = \DB::table('poliklinik')
            ->select('id', 'nama')
            ->where('nama', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2TindakanLaboratorium(Request $request)
    {
        $data = \DB::table('jenis_pemeriksaan_laboratorium')
            ->select('id', 'nama_jenis')
            ->where('nama_jenis', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Tindakan(Request $request)
    {
        $data = \DB::table('tindakan')
            ->select('id', 'tindakan', 'kode')
            ->where('poliklinik_id', '1')
            ->where('tindakan', 'like', "%" . $request->q . "%")
            ->orWhere('kode', 'like', '%' . $request->q . '%')
            ->limit(20)
            ->get();
        // ->join('tbm_icd_nine', 'tbm_icd_nine.id', '=', 'tindakan.kode')
        // ->select('tindakan.id', 'code as kode', 'tindakan')
        // ->where('tindakan', 'like', "%" . $request->q . "%")
        // ->orWhere('code', 'like', '%' . $request->q . '%')
        // ->limit(20)
        // ->get();
        return response()->json($data);
    }

    public function select2ICD(Request $request)
    {
        $data = \DB::table('tbm_icd')
            ->select('id', 'indonesia', 'kode')
            ->where('indonesia', 'like', "%" . $request->q . "%")
            ->orWhere('kode', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2ICDNine(Request $request)
    {
        $data = \DB::table('tbm_icd_nine')
            ->select('id', 'code', 'desc_short')
            ->where('desc_short', 'like', "%" . $request->q . "%")
            ->orWhere('code', 'like', "%" . $request->q . "%")
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

    public function hasilPemeriksaanLabEditable(Request $request)
    {
        if ($request->name !== null && $request->value !== null) {
            HasilPemeriksaanLab::find($request->pk)->update([$request->name => $request->value]);
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

    // pencarian nama TBM dengan element select2
    public function select2TBM(Request $request)
    {
        $data = \DB::table('tbm_icd')
            ->select('id', 'indonesia')
            ->where('indonesia', 'like', "%" . $request->q . "%")
            ->where('dtd', 'K00')
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    // pencarian nama jenis pekerjaan dengan element select2
    public function select2Pekerjaan(Request $request)
    {
        $data = config('datareferensi.jenis_pekerjaan');

        return response()->json($data);
    }

    // pencarian nama suku bangsa dengan element select2
    public function select2SukuBangsa(Request $request)
    {
        $data = config('datareferensi.suku_bangsa');

        return response()->json($data);
    }

    public function nomorAntrialCall(Request $request)
    {
        $total_antrian = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
                ->where('poliklinik_id', $request->poliklinik_id)
                ->count();

        $antrian_sekarang = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
                            ->where('poliklinik_id', $request->poliklinik_id)
                            ->where('sudah_dipanggil', 0)
                            ->first();

        $antrian = \App\Models\NomorAntrian::where('sudah_dipanggil', 0)->where('poliklinik_id', $request->poliklinik_id)->first();
        $antrian->sudah_dipanggil = 1;
        $antrian->save();

        $hasil = [
            'jumlah_total_antrian' => $total_antrian,
            'antrian_sekarang' => $antrian_sekarang->nomor_antrian,
            'sisa_antrian' => $total_antrian - $antrian_sekarang->nomor_antrian
        ];
        return $hasil;
    }

    public function lock_bpjs(Request $request)
    {

        \session(['lock_bpjs' => $request->lock_bpjs]);
        return session('lock_bpjs');
    }

    public function checkPoliKebidanan(Request $request)
    {
        $pendaftaran = \App\Models\Pendaftaran::find($request->pendaftaran_id);
        $value = $pendaftaran->check_list_poli_kebidanan == 0 ? 1 : 0;
        $pendaftaran->update(['check_list_poli_kebidanan' => $value]);
        return $value;
    }
}

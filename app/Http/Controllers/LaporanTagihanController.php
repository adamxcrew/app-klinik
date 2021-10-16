<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTagihanExport;
use Illuminate\Http\Request;
use DataTables;
use App\Models\PendaftaranTindakan;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PerusahaanAsuransi;

class LaporanTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['periode'] = $request->periode ?? date('Y-m');
        $laporanTagihan = PendaftaranTindakan::with(['pendaftaran', 'tindakan']);

        if ($request->periode) {
            $laporanTagihan->whereRaw("left(created_at,7)='".$request->periode."'");
        }

        if ($request->has('nama_perusahaan')) {
            $jenis_layanan = $request->nama_perusahaan;
            $laporanTagihan->whereHas('pendaftaran', function ($query) use ($jenis_layanan) {
                return $query->where('pendaftaran.jenis_layanan', '=', $jenis_layanan);
            });
        }

        if ($request->ajax()) {
            return DataTables::of($laporanTagihan->get())
                ->addColumn('created_at', function ($row) {
                    return tgl_indo(substr($row->created_at, 0, 10));
                })
                ->addColumn('nomor_rekam_medis', function ($row) {
                    return $row->pendaftaran->pasien->nomor_rekam_medis;
                })
                ->addColumn('nama_pasien', function ($row) {
                    return $row->pendaftaran->pasien->nama;
                })
                ->addColumn('tarif_tindakan', function ($row) {
                    $tarif = null;

                    if ($row->pendaftaran->perusahaanAsuransi->nama_perusahaan == 'UMUM') {
                        $tarif = $row->tindakan->tarif_umum;
                    } elseif ($row->pendaftaran->perusahaanAsuransi->nama_perusahaan == 'BPJS') {
                        $tarif = $row->tindakan->tarif_bpjs;
                    } else {
                        $tarif = $row->tindakan->tarif_perusahaan;
                    }
                    return $tarif;
                })
                ->addColumn('dokter', function ($row) {
                    return $row->pendaftaran->dokter->name;
                })
                ->addColumn('poliklinik', function ($row) {
                    return $row->pendaftaran->poliklinik->nama;
                })
                ->addColumn('nama_perusahaan', function ($row) {
                    return $row->pendaftaran->perusahaanAsuransi->nama_perusahaan;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            if ($request->action == 'download') {
                return Excel::download(new LaporanTagihanExport($request->periode, $request->nama_perusahaan??null), 'Laporan Tagihan Perusahaan ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
        }

        $data['perusahaan'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        return view('laporan-tagihan.index', $data);
    }
}

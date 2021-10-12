<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NeracaSaldoExport implements FromView, ShouldAutoSize
{
    public $periode;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $jurnal = Jurnal::with('akun')->groupBy('akun_id')->where('periode', $this->periode)->get();

        $collection = [];
        $i = 0;

        foreach ($jurnal as $j) {
            $debet = DB::table('jurnal')->select(DB::raw('SUM(nominal) as total'))
                ->where('akun_id', $j->akun_id)
                ->where('tipe', 'debet')
                ->first();

            $credit = DB::table('jurnal')->select(DB::raw('SUM(nominal) as total'))
                ->where('akun_id', $j->akun_id)
                ->where('tipe', 'kredit')
                ->first();


            $collection[$i]['id'] = $j->id;
            $collection[$i]['akun'] = $j->akun->nama;
            $collection[$i]['kode'] = $j->akun->kode;
            $collection[$i]['kredit'] = $credit->total;
            $collection[$i]['debet'] = $debet->total;

            $i++;
        }

        $data['neraca_saldo'] = $collection;

        return view('neraca-saldo.laporan-neraca-saldo-excel', $data);
    }
}

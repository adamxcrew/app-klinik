<?php

namespace App\Exports;

use App\Models\PendaftaranFeeTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanFeeTindakanExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $fee = PendaftaranFeeTindakan::with(['tindakan', 'pendaftaran', 'user'])->get();
        return view('laporan-fee-tindakan.laporan-fee-tindakan-excel', ['fees' => $fee]);
    }
}

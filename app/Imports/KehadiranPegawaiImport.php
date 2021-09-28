<?php

namespace App\Imports;

use Exception;
use App\Models\Pegawai;
use App\Models\KehadiranPegawai;
use Maatwebsite\Excel\Concerns\ToModel;

class KehadiranPegawaiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[1] != "No. ID") {
            $pegawai = Pegawai::where('nip', $row[2])->first();
            if ($pegawai) {
                KehadiranPegawai::create([
                    'pegawai_id'  => $pegawai->id,
                    'tanggal' => date('Y-m-d', strtotime($row[5])),
                    'jam_masuk' => $row[7],
                    'jam_keluar' => $row[8],
                    'scan_masuk' => $row[9],
                    'scan_pulang' => $row[10],
                    'status' => $row[12],
                    'shift_id' => 1
                ]);
            } else {
                throw new Exception("Import failed!");
            }
        }
    }
}

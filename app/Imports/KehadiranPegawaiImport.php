<?php

namespace App\Imports;

use Exception;
use App\Models\Pegawai;
use App\Models\Shift;
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
            $pegawai    = Pegawai::where('nip', $row[2])->first();
            $shiftData  = [
                'nama_shift'                    =>  $row[6],
                'jam_masuk'                     =>  $row[7],
                'jam_pulang'                    =>  $row[8],
                'toleransi_terlambat_masuk '    =>  $row[7],
                'toleransi_terlambat_pulang'    =>  $row[8]
            ];

            $shift = Shift::firstOrCreate(['nama_shift'=>$row[6]], $shiftData);

            if ($pegawai) {
                KehadiranPegawai::create([
                    'pegawai_id'    => $pegawai->id,
                    'tanggal'       => date('Y-m-d', strtotime($row[5])),
                    'jam_masuk'     => $row[7],
                    'jam_keluar'    => $row[8],
                    'status'        => $row[13]==null?'hadir':'terlambat',
                    'shift_id'      => $shift->id
                ]);
            } else {
                throw new Exception("Import failed!");
            }
        }
    }
}

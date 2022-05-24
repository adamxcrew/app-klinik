<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Barang;

class ImportBarangExcel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $reader = ReaderEntityFactory::createXLSXReader();
        $filepath = public_path('uploads/' . $this->filePath);
        $reader->open($filepath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $nomor = 1;
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                if ($nomor > 1) {
                    $cells                      = $row->getCells();
                    // dd($cells);
                    $jenis_barang               = $cells[1]->getValue();
                    $kode_barang                = $cells[2]->getValue();
                    $nama_barang                = $cells[3]->getValue();
                    $jumlah_satuan_terbesar     = $cells[4]->getValue();
                    $satuan_terbesar            = Satuan::firstOrCreate(['satuan' => $cells[5]->getValue()], ['satuan' => $cells[5]->getValue()]);
                    $jumlah_satuan_terkecil     = $cells[6]->getValue();
                    $satuan_terkecil            = Satuan::firstOrCreate(['satuan' => $cells[7]->getValue()], ['satuan' => $cells[7]->getValue()]);
                    $jenis                      = Kategori::firstOrCreate(['nama_kategori' => $cells[8]->getValue()], ['nama_kategori' => $cells[8]->getValue(),'jenis' => $jenis_barang]);
                    $harga                      = (int) $cells[9]->getValue();
                    $margin                     = (int) $cells[10]->getValue();
                    $untuk_penjamin             = explode(",", $cells[13]->getValue());
                    //\Log::info($untuk_penjamin);

                    if (in_array('BPJS', $untuk_penjamin)) {
                        $asuransi = "bpjs";
                    } else {
                        $asuransi = "umum";
                    }

                    $data[] = [
                        'kode'                      =>  $kode_barang,
                        'nama_barang'               =>  $nama_barang,
                        'keterangan'                =>  null,
                        'harga'                     =>  $harga,
                        'kategori_id'               =>  $jenis->id,
                        'satuan_terbesar_id'        =>  $satuan_terbesar->id,
                        'jumlah_satuan_terbesar'    =>  $jumlah_satuan_terbesar,
                        'pelayanan'                 =>  $asuransi,
                        'satuan_terkecil_id'        =>  $satuan_terkecil->id,
                        'jumlah_satuan_terkecil'    =>  $jumlah_satuan_terkecil,
                        'margin'                    =>  $margin,
                        'pbf_id'                    =>  0,
                        'aktif'                     =>  1
                    ];
                }
                Barang::insert($data);
                $nomor++;
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use App\Models\Barang;
use App\Models\TindakanBHP;
class TestController extends Controller
{
    function test(Request $request)
    {
        $barangDuplikat = \DB::select("select nama_barang,count(id) as jumlah
        from barang group by nama_barang having jumlah>1");
        foreach ($barangDuplikat as $barang)
        {
            $nama_barang = $barang->nama_barang;
            $barang = Barang::where('nama_barang', $nama_barang)->get();
            foreach ($barang as $br){
                $bhp = TindakanBHP::where('barang_id', $br->id)->first();
                if($bhp==null){
                    \DB::table('barang')->where('id',$br->id)->delete();
                }
            }
        }
    }
}

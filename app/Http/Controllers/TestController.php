<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class TestController extends Controller
{
    function testMikepos(Request $request)
    {
        $connector = new NetworkPrintConnector("127.0.0.1", 9100);
        $printer = new Printer($connector);
        try {
            // ... Print stuff
        } finally {
            $printer -> close();
        }
    }
}

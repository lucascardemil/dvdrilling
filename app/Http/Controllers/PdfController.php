<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function generatePdf(Request $request)
    {
        $data = [
            'proyecto' => $request->reporte['proyecto']['name'],
            'sondaje' => $request->reporte['sondaje'],
            'fecha' => $request->reporte['fecha'],
            'empresa' => $request->reporte['empresa'],
            'sonda' => $request->reporte['sonda'],
            'turno' => $request->reporte['turno'],
            'horas' => $request->reporte['horas'],
            'desde' => $request->reporte['desde'],
            'hasta' => $request->reporte['hasta'],
            'total' => $request->reporte['total'],
            'metros' => $request->reporte['metros'],
            'inclinacion' => $request->reporte['inclinacion'],
            'rumbo' => $request->reporte['metros'],
            'programa' => $request->reporte['metros'],
            'diametro' => $request->reporte['diametro'],
            'horometro' => $request->reporte['horometro'],
            'corona_escareador' => $request->reporte['corona_escareador'],
            'aditivo' => $request->reporte['aditivo'],
            'herramienta' => $request->reporte['herramienta'],
            'perforacion' => $request->reporte['perforacion'],
            'detalle_hora' => $request->reporte['detalle_hora'],
            'observacion' => $request->reporte['observacion'],
        ];

        // Cargar la vista y pasar los datos
        $pdf = PDF::loadView('pdf/pdf', $data);

        // Opcional: Configurar tamaño del papel y orientación (ejemplo: A4 y vertical)
        $pdf->setPaper('A4', 'portrait');

        // Descargar el archivo PDF
        return $pdf->stream('archivo.pdf');
    }
}

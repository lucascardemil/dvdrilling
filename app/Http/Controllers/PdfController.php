<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PdfController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes|checklist');
    }

    public function generarPdfReporte(Request $request)
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
            'adicional' => $request->reporte['adicional'],
            'inclinacion' => $request->reporte['inclinacion'],
            'rumbo' => $request->reporte['rumbo'],
            'programa' => $request->reporte['programa'],
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
        $pdf = PDF::loadView('pdf/pdf_reporte', $data);

        // Opcional: Configurar tamaño del papel y orientación (ejemplo: A4 y vertical)
        $pdf->setPaper('A4', 'portrait');

        // Descargar el archivo PDF
        return $pdf->stream('archivo.pdf');
    }


    public function generarPdfChecklist(Request $request)
    {
        $checklist = $this->obtenerCondiciones($request, $request->checklist);
        // dd($checklist['categorias']);
        // exit;

        $data = [
            'tipo_equipo' => $request->checklist['tipoactivo']['name'],
            'matriz' => $request->checklist['matriz']['nombre'],
            'marca' => $request->checklist['marca'],
            'modelo' => $request->checklist['modelo'],
            'categorias' => $checklist['categorias'],
            'turno' => $checklist['vehiculos']['detalles']['turno'],
            'fecha' => Carbon::parse($checklist['vehiculos']['detalles']['created_at'])->format('d-m-Y H:i'),
            'kilometraje_inicial' => $checklist['vehiculos']['detalles']['kilometraje_inicial'],
            'kilometraje_final' => $checklist['vehiculos']['detalles']['kilometraje_final'],
            'patente' => $checklist['vehiculos']['patente'],
            'numero_interno' => $checklist['vehiculos']['detalles']['numero_interno'],
            'proyecto' => $checklist['vehiculos']['detalles']['proyecto'],
            'faena' => $checklist['vehiculos']['detalles']['faena'],
            'conductor' => $checklist['vehiculos']['detalles']['conductor'],
            'estado_equipo' => $checklist['vehiculos']['detalles']['estado_equipo'],
            'carga_combustible' => $checklist['vehiculos']['detalles']['carga_combustible'],
            'litros' => $checklist['vehiculos']['detalles']['litros'],
            'observacion_bitacora' => $checklist['vehiculos']['detalles']['observacion_bitacora'],
            'imagen_combustible'  => str_replace("public/", "storage/", $checklist['vehiculos']['detalles']['imagen_combustible']),
        ];


        $pdf = PDF::loadView('pdf/pdf_checklist', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('archivo.pdf');
    }

    public function obtenerCondiciones($checklist_vehiculo, $checklist)
    {
        if (!$checklist_vehiculo || !$checklist) {
            return null;
        }

        // Crear una copia profunda del checklist
        $checklistNuevo = json_decode(json_encode($checklist), true);

        // Iterar por las categorías dentro del nuevo checklist
        if (!empty($checklistNuevo['categorias'])) {
            foreach ($checklistNuevo['categorias'] as &$categoria) {
                // Iterar por las intervenciones dentro de cada categoría
                if (!empty($categoria['intervenciones'])) {
                    foreach ($categoria['intervenciones'] as &$intervencion) {
                        // Verificar si tiene condiciones
                        if (!empty($intervencion['condiciones'])) {
                            // Filtrar las condiciones que coinciden con los ids de checklist_vehiculo
                            $intervencion['condiciones'] = array_values(array_filter($intervencion['condiciones'], function ($condicion) use ($checklist_vehiculo) {
                                return $condicion['checklist_vehiculo_detalle_id'] === $checklist_vehiculo['check_list_vehiculo_detalle_id'] &&
                                    $condicion['checklist_vehiculo_id'] === $checklist_vehiculo['check_list_vehiculo_id'];
                            }));
                        }
                    }
                }
            }
        }

        // Filtrar el vehículo que coincide con check_list_vehiculo_id
        $vehiculoFiltrado = null;
        if (!empty($checklistNuevo['vehiculos'])) {
            foreach ($checklistNuevo['vehiculos'] as $vehiculo) {
                if ($vehiculo['id'] === $checklist_vehiculo['check_list_vehiculo_id']) {
                    $vehiculoFiltrado = $vehiculo;
                    break;
                }
            }
        }

        if (!$vehiculoFiltrado) {
            return null;
        }

        // Filtrar los detalles del vehículo
        if (!empty($vehiculoFiltrado['detalles'])) {
            $vehiculoFiltrado['detalles'] = array_filter($vehiculoFiltrado['detalles'], function ($detalle) use ($checklist_vehiculo) {
                return $detalle['id'] === $checklist_vehiculo['check_list_vehiculo_detalle_id'] &&
                    $detalle['checklist_vehiculo_id'] === $checklist_vehiculo['check_list_vehiculo_id'];
            });

            // Solo mantener el primer detalle si existe
            $vehiculoFiltrado['detalles'] = reset($vehiculoFiltrado['detalles']);
        }

        // Mantener solo el vehículo filtrado en el checklist
        $checklistNuevo['vehiculos'] = $vehiculoFiltrado;

        // Retornar el checklist nuevo con las modificaciones
        return $checklistNuevo;
    }
}

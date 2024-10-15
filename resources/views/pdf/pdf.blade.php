<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DVdrilling') }}</title>
    <style>
        @font-face {
            font-family: "Nunito";
            font-weight: 100;
            font-style: normal;
            src: url('{{ storage_path('fonts/Nunito-Light.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: "Nunito";
            font-weight: 400;
            font-style: normal;
            src: url('{{ storage_path('fonts/Nunito-Regular.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: "Nunito";
            font-weight: 700;
            font-style: normal;
            src: url('{{ storage_path('fonts/Nunito-Bold.ttf') }}') format('truetype');
        }

        table {
            width: 100%;
        }

        .titulo-reporte {
            font-family: 'Nunito';
            font-weight: 700;
        }

        .datos-principal,
        .avance-turno {
            margin: 20px 0px;
            table-layout: fixed;
        }

        .datos-principal .texto,
        .avance-turno .texto {
            font-family: 'Nunito';
            font-weight: 700;
            font-size: 12px;
        }

        .datos-principal .texto small,
        .avance-turno .texto small {
            font-family: 'Nunito';
            font-weight: 400;
            font-size: 12px;
        }

        .horometro {
            margin: 20px 0px;
            table-layout: fixed;
            border: 1px solid black;
            text-align: center;
        }

        .horometro .texto {
            font-family: 'Nunito';
            font-weight: 700;
            font-size: 12px;
        }

        .horometro .texto small {
            font-family: 'Nunito';
            font-weight: 400;
            font-size: 12px;
        }

        .control-coronas-escareadores,
        .consumo-aditivos,
        .perforacion-roca,
        .control-herramienta,
        .detalle-horas {
            border-collapse: collapse;
        }

        .control-coronas-escareadores th,
        .control-coronas-escareadores td,
        .consumo-aditivos th,
        .consumo-aditivos td,
        .perforacion-roca th,
        .perforacion-roca td {
            font-family: 'Nunito';
            font-weight: 700;
            font-size: 10px;
            border: 1px solid black;
        }

        .control-herramienta td {
            font-family: 'Nunito';
            font-weight: 700;
            font-size: 10px;
        }

        .detalle-horas td {
            font-family: 'Nunito';
            font-weight: 700;
            font-size: 10px;
        }

        .observacion .texto-observacion {
            font-family: 'Nunito';
            font-weight: 700;
            font-size: 10px;
        }
    </style>

</head>

<body>
    <table>
        <tr>
            <td><img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width: 150px; height: auto;"></td>
            <td>
                <h5 class="titulo-reporte">REPORT CONTROL DE SONDAJE DIAMANTINOS</h5>
            </td>
        </tr>
    </table>

    <h5 class="titulo-reporte">DATOS PRINCIPALES</h5>
    <table class="datos-principal">
        <tr>
            <td>
                <label class="texto">UBICACION: <small>{{ $proyecto }}</small></label>
            </td>
            <td>
                <label class="texto">SONDAJE: <small>{{ $sondaje }}</small></label>
            </td>
            <td>
                <label class="texto">FECHA: <small>{{ $fecha }}</small></label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto">EMPRESA: <small>{{ $empresa }}</small></label>
            </td>
            <td>
                <label class="texto">SONDA: <small>{{ $sonda }}</small></label>
            </td>
            <td>
                <label class="texto">TURNO: <small>{{ $turno }}</small></label>
            </td>
            <td>
                <label class="texto">HRS: <small>{{ $horas }}</small></label>
            </td>
        </tr>
    </table>

    <h5 class="titulo-reporte">AVANCE DEL TURNO</h5>
    <table class="avance-turno">
        <tr>
            <td>
                <label class="texto">DESDE: <small>{{ $desde }}</small></label>
            </td>
            <td>
                <label class="texto">HASTA: <small>{{ $hasta }}</small></label>
            </td>
            <td>
                <label class="texto">TOTAL: <small>{{ $total }}</small></label>
            </td>
            <td>
                <label class="texto">MTS: <small>{{ $metros }}</small></label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto">INCLINACION: <small>{{ $inclinacion }}</small></label>
            </td>
            <td>
                <label class="texto">RUMBO: <small>{{ $rumbo }}</small></label>
            </td>
            <td>
                <label class="texto">PROGRAMA: <small>{{ $programa }}</small></label>
            </td>
            <td>
                <label class="texto">MTS: <small>{{ $metros }}</small></label>
            </td>
            <td>
                <label class="texto">DIAMETRO: <small>{{ $diametro }}</small></label>
            </td>
        </tr>
    </table>


    <table class="horometro">
        @for ($i = 0; $i < count($horometro); $i++)
            <tr>
                <td>
                    <label class="texto">HOROMETRO INICIO: <small>{{ $horometro[$i]['inicio'] }}</small></label>
                </td>
                <td>
                    <label class="texto">HOROMETRO TERMINO: <small>{{ $horometro[$i]['termino'] }}</small></label>
                </td>
                <td>
                    <label class="texto">N° CAJAS: <small>{{ $horometro[$i]['numero_cajas'] }}</small></label>
                </td>
            </tr>
        @endfor
    </table>

    <table style="table-layout: fixed">
        <tr>
            <td>
                <h5 class="titulo-reporte" style="text-align: center; margin: 0; padding: 0;">CONTROL CORONAS Y
                    ESCAREADORES</h5>
            </td>
            <td>
                <h5 class="titulo-reporte" style="text-align: center; margin: 0; padding: 0;">CONTROL DE ADITIVOS</h5>
            </td>
        </tr>
        <tr>
            <td>
                <table class="control-coronas-escareadores">

                    <head>
                        <tr>
                            <th>DETALLE</th>
                            <th>DESDE</th>
                            <th>HASTA</th>
                            <th>DIAMETRO</th>
                            <th>N° CORONA</th>
                        </tr>
                    </head>
                    <tbody>
                        @for ($i = 0; $i < count($corona_escareador); $i++)
                            <tr>
                                <td>{{ $corona_escareador[$i]['detalle'] }}</td>
                                <td>{{ $corona_escareador[$i]['desde'] }}</td>
                                <td>{{ $corona_escareador[$i]['hasta'] }}</td>
                                <td>{{ $corona_escareador[$i]['diametro'] }}</td>
                                <td>{{ $corona_escareador[$i]['numero_corona'] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>
            <td style="vertical-align: top">
                <table class="consumo-aditivos">

                    <head>
                        <tr>
                            <th class="titulo-cantidad">CANTIDAD</th>
                            <th>DETALLE</th>
                        </tr>
                    </head>
                    <tbody>
                        @for ($i = 0; $i < count($aditivo); $i++)
                            <tr>
                                <td>{{ $aditivo[$i]['cantidad'] }}</td>
                                <td>{{ $aditivo[$i]['detalle'] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>
        </tr>
    </table>


    <table style="table-layout: fixed">
        <tr>
            <td>
                <h5 class="titulo-reporte" style="text-align: center; margin: 0; padding: 0;">PERFORACIÓN EN ROCA</h5>
            </td>
            <td>
                <h5 class="titulo-reporte" style="text-align: center; margin: 0; padding: 0;">CONTROL DE HERRAMIENTA
                </h5>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top">
                <table class="perforacion-roca">

                    <head>
                        <tr>
                            <th>DESDE</th>
                            <th>HASTA</th>
                            <th>PERFORADO</th>
                            <th>RECUPERADO</th>
                            <th>%</th>
                            <th>N° CAJAS</th>
                        </tr>
                    </head>
                    <tbody>
                        @for ($i = 0; $i < count($perforacion); $i++)
                            <tr>
                                <td>{{ $perforacion[$i]['desde'] }}</td>
                                <td>{{ $perforacion[$i]['hasta'] }}</td>
                                <td>{{ $perforacion[$i]['perforado'] }}</td>
                                <td>{{ $perforacion[$i]['recuperado'] }}</td>
                                <td>{{ $perforacion[$i]['porcentaje'] }}%</td>
                                <td>{{ $perforacion[$i]['numero_cajas'] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>
            <td>
                <table class="control-herramienta">
                    @for ($i = 0; $i < count($herramienta); $i++)
                        <tr>
                            <td>
                                <label class="texto">BARRAS 3,00</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['barras_3'] }}</label>
                            </td>
                            <td>
                                <label class="texto">x 3,00</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['barras_3'] * 3 }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">BARRAS 3,05</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['barras_3_5'] }}</label>
                            </td>
                            <td>
                                <label class="texto">x 3,05</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['barras_3_5'] * 3.05 }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">SUBTOTAL</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label
                                    class="texto">{{ $herramienta[$i]['barras_3'] * 3 + $herramienta[$i]['barras_3_5'] * 3.05 }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">BARRIL</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['barril'] }}</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['total_barril'] }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">SUBTOTAL</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label
                                    class="texto">{{ $herramienta[$i]['barras_3'] * 3 + $herramienta[$i]['barras_3_5'] * 3.05 + $herramienta[$i]['total_barril'] }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">MUERTO</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['muerto'] }}</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">HERRAMIENTA TOTAL</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label
                                    class="texto">{{ $herramienta[$i]['barras_3'] * 3 + $herramienta[$i]['barras_3_5'] * 3.05 + $herramienta[$i]['total_barril'] - $herramienta[$i]['muerto'] }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">CONTRA</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['contra'] }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="texto">TOTAL</label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label class="texto"></label>
                            </td>
                            <td>
                                <label
                                    class="texto">{{ $herramienta[$i]['barras_3'] * 3 + $herramienta[$i]['barras_3_5'] * 3.05 + $herramienta[$i]['total_barril'] - $herramienta[$i]['muerto'] - $herramienta[$i]['contra'] }}</label>
                            </td>
                        </tr>


                        <tr style="border: 1px solid black">
                            <td>
                                <label class="texto">F. INICIO:</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['f_inicio'] }}</label>
                            </td>
                            <td>
                                <label class="texto">AVANCE:</label>
                            </td>
                            <td>
                                <label
                                    class="texto">{{ $herramienta[$i]['f_termino'] - $herramienta[$i]['f_inicio'] }}</label>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black">
                            <td>
                                <label class="texto">F. TÉRMINO:</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['f_termino'] }}</label>
                            </td>
                            <td>
                                <label class="texto">% RECUP.:</label>
                            </td>
                            <td>
                                <label class="texto">{{ $herramienta[$i]['recuperacion'] }}%</label>
                            </td>
                        </tr>
                    @endfor
                </table>

                <table>
                    <tr>
                        <td>
                            <h5 class="titulo-reporte" style="text-align: center; margin: 0; padding: 0;">DETALLE HORAS
                            </h5>
                        </td>
                    </tr>
                </table>

                <table class="detalle-horas" style="table-layout: fixed">
                    @for ($i = 0; $i < count($detalle_hora); $i++)
                        <tr>
                            <td>
                                <label class="texto">DE</label>
                            </td>
                            <td>
                                <label class="texto">{{ substr($detalle_hora[$i]['de'], 0, -3) }}</label>
                            </td>
                            <td>
                                <label class="texto">A</label>
                            </td>
                            <td>
                                <label class="texto">{{ substr($detalle_hora[$i]['a'], 0, -3) }}</label>
                            </td>
                            <td>
                                <label class="texto">{{ $detalle_hora[$i]['actividad']['name'] }}</label>
                            </td>
                        </tr>
                    @endfor
                </table>
            </td>
        </tr>
    </table>

    <table class="observacion">
        <tr>
            <td>
                <h5 class="titulo-reporte" style="margin: 0; padding: 0;">OBSERVACIONES</h5>
            </td>
        </tr>
        @for ($i = 0; $i < count($observacion); $i++)
            <tr>
                <td style="border: 1px solid black" class="texto-observacion">
                    {{ $observacion[$i]['observacion'] }}
                </td>
            </tr>
        @endfor
    </table>

    <table class="datos-principal">
        <tr>
            <td>
                <label class="texto">SONDEADOR: </label>
            </td>
            <td>
                <label class="texto">AYUDANTE: </label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto">SUPERVISOR: </label>
            </td>
            <td>
                <label class="texto">V°B° CLIENTE: </label>
            </td>
        </tr>
    </table>
</body>

</html>

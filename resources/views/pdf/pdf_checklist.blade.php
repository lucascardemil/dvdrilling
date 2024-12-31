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

        .texto {
            font-size: 12px;
            font-family: 'Nunito';
            font-weight: 700;
        }

        .texto small {
            font-family: 'Nunito';
            font-weight: 400;
        }

        .datos-principal {
            margin: 20px 0px;
            table-layout: fixed;
        }

        .datos-principal .texto {
            font-family: 'Nunito';
            font-weight: 700;
        }

        .datos-principal .texto small {
            font-family: 'Nunito';
            font-weight: 400;
        }

        .checklist {
            border-collapse: collapse;
        }

        .checklist th,
        .checklist td {
            padding: 5px;
            text-align: center;
        }

        .checklist .titulo-categoria {
            background-color: #fd7e14;
        }

        .checklist th,
        .checklist td {
            font-size: 12px;
            font-family: 'Nunito';
            font-weight: 700;
            border: 1px solid black;
        }

        .status-equipo {
            width: 300px;
            border-collapse: collapse;
            margin: 20px 0px;
            table-layout: fixed;
        }

        .status-equipo .texto {
            font-family: 'Nunito';
            font-weight: 700;
        }

        .status-equipo .texto small {
            font-family: 'Nunito';
            font-weight: 400;
        }

        .status-equipo .titulo {
            background-color: #fd7e14;
        }

        .status-equipo th,
        .status-equipo td {
            padding: 5px;
        }

        .status-equipo th,
        .status-equipo td {
            font-size: 12px;
            font-family: 'Nunito';
            font-weight: 700;
            border: 1px solid black;
        }

        .carga-combustible {
            width: 300px;
            border-collapse: collapse;
            margin: 20px 0px;
            table-layout: fixed;
        }

        .carga-combustible .texto {
            font-family: 'Nunito';
            font-weight: 700;
        }

        .carga-combustible .texto small {
            font-family: 'Nunito';
            font-weight: 400;
        }

        .carga-combustible .titulo {
            background-color: #fd7e14;
        }

        .carga-combustible th,
        .carga-combustible td {
            padding: 5px;
        }

        .carga-combustible th,
        .carga-combustible td {
            font-size: 12px;
            font-family: 'Nunito';
            font-weight: 700;
            border: 1px solid black;
        }

        .observacion-vitacora {
            border-collapse: collapse;
            margin: 20px 0px;
            table-layout: fixed;
        }

        .observacion-vitacora .texto {
            font-family: 'Nunito';
            font-weight: 700;
        }

        .observacion-vitacora .texto small {
            font-family: 'Nunito';
            font-weight: 400;
        }

        .observacion-vitacora .titulo {
            background-color: #fd7e14;
        }

        .observacion-vitacora th,
        .observacion-vitacora td {
            padding: 5px;
        }

        .observacion-vitacora th,
        .observacion-vitacora td {
            font-size: 12px;
            font-family: 'Nunito';
            font-weight: 700;
            border: 1px solid black;
        }

        img {
            width: 15px;
            height: auto;
        }

        .table td {
            border: 1px solid black;
        }
    </style>

</head>

<body>
    <table>
        <tr>
            <td><img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width: 150px; height: auto;"></td>
            <td>
                <h4 class="titulo-reporte">CHECKLIST DVDRILLING</h4>
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            <label class="texto">TURNO: <small>{{ $turno }}</small></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="texto">FECHA: <small>{{ $fecha }}</small></label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="datos-principal">
        <tr>
            <td>
                <label class="texto">Nombre del chofer: <small>{{ $conductor }}</small></label>
            </td>
            <td>
                <label class="texto">Kilometraje Inicial: <small>{{ $kilometraje_inicial }}</small></label>
            </td>
            <td>
                <label class="texto">Nº Interno: <small>{{ $numero_interno }}</small></label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto">Marca: <small>{{ $marca }}</small></label>
            </td>
            <td>
                <label class="texto">Kilometraje Final: <small>{{ $kilometraje_final }}</small></label>
            </td>
            <td>
                <label class="texto">Proyecto: <small>{{ $proyecto }}</small></label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto">Modelo: <small>{{ $modelo }}</small></label>
            </td>
            <td>
                <label class="texto">Patente: <small>{{ $patente }}</small></label>
            </td>
            <td>
                <label class="texto">Faena: <small>{{ $faena }}</small></label>
            </td>
        </tr>
    </table>


    <table class="checklist">
        <thead>
            <tr>
                <th rowspan="2">Categoria</th>
                <th colspan="2">Aplica</th>
                <th colspan="3">Estado</th>
                <th rowspan="2">Observacion</th>
            </tr>
            <tr>
                <th>SI</th>
                <th>NO</th>
                <th><img src="{{ public_path('images/emoji_feliz.png') }}"></th>
                <th><img src="{{ public_path('images/emoji_neutral.png') }}"></th>
                <th><img src="{{ public_path('images/emoji_triste.png') }}"></th>
            </tr>
        </thead>
        <tbody>
            @if (count($categorias) > 0)
                @for ($ca = 0; $ca < count($categorias); $ca++)
                    @if (count($categorias[$ca]['intervenciones']) > 0)
                        @for ($in = 0; $in < count($categorias[$ca]['intervenciones']); $in++)
                            @if (count($categorias[$ca]['intervenciones'][$in]['condiciones']) > 0)
                                <tr>
                                    <th colspan="7" class="titulo-categoria">{{ $categorias[$ca]['nombre'] }}</th>
                                </tr>
                                <tr>
                                    <td>{{ $categorias[$ca]['intervenciones'][$in]['nombre'] }}</td>


                                    @for ($co = 0; $co < count($categorias[$ca]['intervenciones'][$in]['condiciones']); $co++)
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['existe'] == 1)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['existe'] == 2)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['estado'] == 1)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['estado'] == 2)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['estado'] == 3)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif

                                        @if (count($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['imagenes']) > 0)
                                            @for ($im = 0; $im < count($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['imagenes']); $im++)
                                                @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['imagenes'][$im]['observacion'] != '')
                                                    <td>{{ $categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['imagenes'][$im]['observacion'] }}
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endfor
                                        @else
                                            <td></td>
                                        @endif

                    
                                    @endfor
                                </tr>
                            @endif
                        @endfor
                    @endif
                @endfor
            @endif

        </tbody>
    </table>

    <table>
        <tr>
            <td style="width: 300px;">
                <table>
                    <tr>
                        <td>
                            <table class="status-equipo">
                                <tr>
                                    <td class="titulo">
                                        <label class="texto">STATUS EQUIPO</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="texto">OPERATIVO:
                                            @if ($estado_equipo === 1)
                                                <small>
                                                    <img src="{{ public_path('images/emoji_check.png') }}">
                                                </small>
                                            @endif
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="texto">F/SERVICIO:
                                            @if ($estado_equipo === 0)
                                                <small>
                                                    <img src="{{ public_path('images/emoji_check.png') }}">
                                                </small>
                                            @endif
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                    <tr>
                        <td>
                            <table class="carga-combustible">
                                <tr>
                                    <td class="titulo">
                                        <label class="texto">CARGA DE COMB.</label>
                                    </td>
                                    <td class="titulo">
                                        <label class="texto">LTS.</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="texto">SI:
                                            @if ($carga_combustible === 1)
                                                <small>
                                                    <img src="{{ public_path('images/emoji_check.png') }}">
                                                </small>
                                            @endif
                                        </label>
                                    </td>
                                    <td>
                                        @if ($carga_combustible === 1)
                                            <small>
                                                {{ $litros }}
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="texto">NO:
                                            @if ($carga_combustible === 0)
                                                <small>
                                                    <img src="{{ public_path('images/emoji_check.png') }}">
                                                </small>
                                            @endif
                                        </label>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center">
                <label class="texto">INDIQUE NIVEL DE COMBUSTIBLE AL INICIAR EL TURNO</label>
                @if ($imagen_combustible)
                    <img src="{{ public_path($imagen_combustible) }}" style="width: 100%; height: 200px;">
                @endif 
            </td>
        </tr>
    </table>

    <table class="observacion-vitacora">
        <tr>
            <td class="titulo">
                <label class="texto">OBSERVACIONES (VITACORA)</label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto"><small>{{ $observacion_bitacora }}</small></label>
            </td>
        </tr>
    </table>

</body>

</html>

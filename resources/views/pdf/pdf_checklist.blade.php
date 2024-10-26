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

        .checklist th,
        .checklist td {
            font-family: 'Nunito';
            font-weight: 700;
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
        </tr>
    </table>

    <table class="datos-principal">
        <tr>
            <td>
                <label class="texto">TIPO EQUIPO: <small>{{ $tipo_equipo }}</small></label>
            </td>
            <td>
                <label class="texto">MATRIZ CHECKLIST: <small>{{ $matriz }}</small></label>
            </td>
        </tr>
        <tr>
            <td>
                <label class="texto">MARCA: <small>{{ $marca }}</small></label>
            </td>
            <td>
                <label class="texto">MODELO: <small>{{ $modelo }}</small></label>
            </td>
        </tr>
    </table>


    <table class="checklist">
        <thead>
            <tr>
                <th rowspan="2">Categoria</th>
                <th colspan="2">Existe</th>
                <th colspan="3">Estado</th>
                {{-- <th rowspan="2">Observacion</th> --}}
            </tr>
            <tr>
                <th>SI</th>
                <th>NO</th>
                <th><img src="{{ public_path('images/emoji_feliz.png') }}" style="width: 24px; height: auto;"></th>
                <th><img src="{{ public_path('images/emoji_neutral.png') }}" style="width: 24px; height: auto;"></th>
                <th><img src="{{ public_path('images/emoji_triste.png') }}" style="width: 24px; height: auto;"></th>
            </tr>
        </thead>
        <tbody>
            @if (count($categorias) > 0)
                @for ($ca = 0; $ca < count($categorias); $ca++)
                    @if (count($categorias[$ca]['intervenciones']) > 0)
                        <tr>
                            <th colspan="6">{{ $categorias[$ca]['nombre'] }}</th>
                        </tr>
                        <tr>
                            @for ($in = 0; $in < count($categorias[$ca]['intervenciones']); $in++)
                                <td>{{ $categorias[$ca]['intervenciones'][$in]['nombre'] }}</td>

                                @if (count($categorias[$ca]['intervenciones'][$in]['condiciones']) > 0)
                                    @for ($co = 0; $co < count($categorias[$ca]['intervenciones'][$in]['condiciones']); $co++)
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['existe'] == 1)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}"
                                                    style="width: 20px; height: auto;">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['existe'] == 2)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}"
                                                    style="width: 20px; height: auto;">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['estado'] == 1)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}"
                                                    style="width: 20px; height: auto;">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['estado'] == 2)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}"
                                                    style="width: 20px; height: auto;">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($categorias[$ca]['intervenciones'][$in]['condiciones'][$co]['estado'] == 3)
                                            <td>
                                                <img src="{{ public_path('images/emoji_check.png') }}"
                                                    style="width: 20px; height: auto;">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                @endif
                            @endfor
                        </tr>
                    @endif
                @endfor
            @endif

        </tbody>
    </table>
</body>

</html>

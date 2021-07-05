<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pdf</title>

    <link href="{{ public_path('css/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <style>
.table-borderless > tbody > tr > td,
.table-borderless > tbody > tr > th,
.table-borderless > tfoot > tr > td,
.table-borderless > tfoot > tr > th,
.table-borderless > thead > tr > td,
.table-borderless > thead > tr > th {
    border: none;
}
    </style>

</head>
<body>
    <div class="container">
        <table class="table table-borderless">
            <tr>
                <td width="50%">
                    <img src="{{ public_path('images/logo.jpg') }}" width="200" height="200">
                </td>
                <td>
                    <div class="text-left">
                        <h4>Nombre de la empresa</h4><br>
                        <ul class="list-unstyled">
                            <li>
                                <b>Dirección:</b> <span class="text-muted">hidalgo #45</span>
                            </li>
                            <li>
                                <b>Telefono:</b> <span class="text-muted">331002340</span>
                            </li>
                            <li>
                                <b>Correo electronico:</b> <span class="text-muted">correo@hotmail.com</span>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-borderless" >
            <tr>
                <td rowspan="2" width="50%">
                    <table>
                        <tr>
                            <th>Cliente</th>
                        </tr>
                        <tr>
                            <td>
                                <b>Nombre:</b>
                                <span class="text-muted">
                                    {{ $datos[0]->buyer->name }} {{  $datos[0]->buyer->profile->surnames }}
                                </span>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <b>Correo electronico:</b>
                                <span class="text-muted">
                                    {{ $datos[0]->buyer->email }}
                                </span>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <b>Teléfono:</b>
                                <span class="text-muted">
                                    {{ $datos[0]->buyer->profile->phone }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Dirección:</b>
                                <span class="text-muted text-capitalize">
                                    {{ $datos[0]->buyer->profile->address }},
                                    {{ $datos[0]->buyer->profile->city }},
                                    {{ $datos[0]->buyer->profile->state }},
                                    {{ $datos[0]->buyer->profile->country }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="table" style="background: #fafafa">
                        <tr>
                            <td width="50%">
                                <b>Fecha</b><br>
                                <span class="text-muted">{{ $datos[0]->created_at }}</span>
                            </td>
                            <td>
                                <b>Número de factura</b><br>
                                 <span class="text-muted">{{ $datos[0]->invoice_number }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-striped table-responsive-md btn-table">

            <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
            </thead>

            <tbody>
                @foreach ($datos[0]->sale->transactions as $item)
                  <tr>
                    <td>
                        {{ $item->product->name }}
                        {{ $item->product->type->name }}
                        {{ $item->product->size->name }}
                    </td>
                    <td>
                        ${{ number_format($item->unit_price, 2) }}
                    </td>
                    <td>
                        {{ $item->quantity }}
                    </td>
                    <td>
                        ${{  number_format($item->subtotal, 2) }}
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table table-striped table-responsive-md btn-table" style="width: 30%;">
                <tr>
                    <td><b>Subtotal</b></td>
                    <td><b>${{  number_format($datos[0]->sale->subtotal, 2) }}</b></td>
                </tr>
                <tr>
                    <td>Descuento</td>
                    <td>${{  number_format($datos[0]->sale->discount, 2) }}</td>
                </tr>
                <tr class="info">
                    <td style="font-size: 18px">Gran Total</td>
                    <td style="font-size: 18px">${{  number_format($datos[0]->sale->total, 2) }}</td>
                </tr>
        </table>
    </div>
</body>
</html>
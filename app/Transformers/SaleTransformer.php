<?php

namespace App\Transformers;

use App\Sale;
use App\buyer;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransactionTransformer;

class SaleTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'cliente', 'venta'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Sale $sale)
    {
        return [
            'identificador' => (int)$sale->id,
            'numero_compra' => (int)$sale->number_order,
            'comprobante' => $sale->voucher,
            'impuesto' => $sale->tax,
            'total' => (double)$sale->total,
            'subtotal' => (double)$sale->subtotal,
            'descuento' => (double)$sale->discount,
            'gasto_envio' => (double)$sale->shipping_costs,
            'estatus' => $sale->status,
            'observacion' => $sale->observation,
            'transactions' => $sale->transactions,
            'recibo_pdf' => (string)route('sales.receipts.index', $sale->number_order),
            'fechaCreacion' => (string)$sale->created_at,
            'fechaActualizacion' => (string)$sale->updated_at,
            'fechaEliminacion' => isset($sale->deleted_at) ? (string) $sale->deleted_at : null,
        ];
    }

     public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'numero_compra' => 'number_order',
            'comprador' => 'buyer_id',
            'comprobante' => 'voucher',
            'impuesto' => 'tax',
            'total' => 'total',
            'subtotal' => 'subtotal',
            'descuento' => 'discount',
            'gasto_envio' => 'shipping_costs',
            'estatus' => 'status',
            'observacion' => 'observation',
            'transactions' => 'transactions',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identificador',
            'number_order' => 'numero_compra',
            'buyer_id' => 'comprador',
            'voucher' => 'comprobante',
            'tax' => 'impuesto',
            'total' => 'total',
            'subtotal' => 'subtotal',
            'discount' => 'descuento',
            'shipping_costs' => 'gasto_envio',
            'status' => 'estatus',
            'observation' => 'observacion',
            'transactions' => 'transactions',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

     public function includeCliente(Sale $sale) {
        $cliente = Buyer::find($sale->buyer_id);
        return $this->item($cliente, new BuyerTransformer);
    }

    public function includeVenta(Sale $sale) {
        $venta = $sale->transactions;
        return $this->collection($venta, new TransactionTransformer);
    }
}

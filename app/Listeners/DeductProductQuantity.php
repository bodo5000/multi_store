<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        foreach ($order->products as $product) {
            $product->decrement('quantity', $product->order_item->quantity);


            // Product::where('id', $item->product_id)
            //     ->update([
            //         //                    UPDATE products SET quantity = quantity - 1
            //         'quantity' => DB::raw("quantity - {$item->quantity}")
            //     ]);
        }
    }
}

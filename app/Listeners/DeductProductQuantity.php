<?php

namespace App\Listeners;

use App\Facades\Cart;
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
    public function handle(): void
    {
        foreach (Cart::get() as $item) {
            Product::where('id', $item->product_id)
                ->update([
                    //                    UPDATE products SET quantity = quantity - 1
                    'quantity' => DB::raw("quantity - {$item->quantity}")
                ]);
        }
    }
}

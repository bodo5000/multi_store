<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function __construct(public CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function create()
    {
        if ($this->cart->get()->count() == 0) {
            throw new InvalidOrderException('cart is empty');
            // return redirect()->route('front.home');
        }
        return view('front.checkout', ['cart' => $this->cart, 'countries' => Countries::getNames()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'addr.billing.first_name' => ['required', 'string', 'max:255'],
            'addr.billing.last_name' => ['required', 'string', 'max:255'],
            'addr.billing.email' => ['required', 'string', 'max:255'],
            'addr.billing.phone_number' => ['required', 'string', 'max:255'],
            'addr.billing.city' => ['required', 'string', 'max:255'],
            'addr.shipping.first_name' => ['required', 'string', 'max:255'],
            'addr.shipping.last_name' => ['required', 'string', 'max:255'],
            'addr.shipping.email' => ['required', 'string', 'max:255'],
            'addr.shipping.phone_number' => ['required', 'string', 'max:255'],
            'addr.shipping.city' => ['required', 'string', 'max:255'],
        ]);
        $items = $this->cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }
                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            // $this->cart->empty();
            DB::commit();

            // event('order.created', $order, auth()->user());
            event(new OrderCreated($order));

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('cart.index');
    }

}

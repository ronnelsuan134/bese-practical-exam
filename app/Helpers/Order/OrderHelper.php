<?php

namespace App\Helpers\Order;

use App\Models\Order;
use App\Models\Product;

class OrderHelper
{

    public static function Order($id, $qty)
    {
        $product = Product::firstWhere('id', $id);
        $remainingStock = $product->available_stock;
        $orders = [];
        if ($remainingStock < $qty) {
            return Self::FailedOder();
        } else {
            if (isset($orders[$id])) {
                $msg = 'Already in Cart!';
            } else {
                // if item not exist in cart then add to cart 
                $orders[$id] = [
                    'name' => $product->name,
                    'qty' => $qty
                ];
                foreach ($orders as $id => $order) {
                    Order::create([
                        'product_id' => $id,
                        'quantity' => $order['qty']
                    ]);
                    $updatedStock = $remainingStock - $order['qty'];
                    $product->available_stock = $updatedStock;
                    $product->save();
                }
                return Self::SuccessOrder();
            }
        }
    }

    public static function SuccessOrder()
    {
        $responseCode = 201;
        $msg = 'You have successfully ordered this product.';

        $data = ['msg' => $msg, 'res' => $responseCode];
        return $data;
    }

    public static function FailedOder()
    {
        $responseCode = 400;
        $msg = 'Failed to order this product due to unavailability of the stock';

        $data = ['msg' => $msg, 'res' => $responseCode];
        return $data;
    }
}

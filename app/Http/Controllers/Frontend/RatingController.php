<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function add(Request $request)
    {
        try {
            $stars_rated = $request->input('product_rating');
            $product_id = $request->input('product_id');

            $product_check = Product::where('id', $product_id)->where('status', '0')->first();
            if ($product_check) {
                $verified_purchase = Order::where('orders.user_id', Auth::id())->join('order_items','orders.id','order_items.order_id')->where('order_items.prod_id', $product_id)->get();

                if ($verified_purchase->count() > 0) {

                    $existing_rating = Rating::where('user_id', Auth::id())->where('prod_id', $product_id)->first();

                    if ($existing_rating) {
                        $existing_rating->stars_rated = $stars_rated;
                        $existing_rating->update();

                    }else{

                        Rating::create([
                            'user_id'=> Auth::id(),
                            'prod_id'=> $product_id,
                            'stars_rated'=> $stars_rated
                        ]);
                    }
                    return redirect()->back()->with('status', "Cảm ơn bạn đã đánh giá sản phẩm này");

                } else {
                    return redirect()->back()->with('status', "Bạn không thể đánh giá sản phẩm khi chưa mua sản phẩm này");
                }

            }else {
                return redirect()->back()->with('status', "The link you followed was broken");
            }
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
}

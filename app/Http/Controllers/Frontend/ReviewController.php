<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function create(Request $request)
    {
        try {
            $prod_id = $request->input('prod_id');
            $user_review = $request->input('user_review');

            $product_check = Product::where('id', $prod_id)->where('status', '0')->first();
            if ($product_check) {
                $verified_purchase = Order::where('orders.user_id', Auth::id())->join('order_items','orders.id','order_items.order_id')->where('order_items.prod_id', $prod_id)->get();
                if ($verified_purchase->count() > 0) {
                    Review::create([
                        'user_id' => Auth::id(),
                        'prod_id' => $prod_id,
                        'user_review' => $user_review,
                    ]);
                    return redirect()->back()->with('status', "Cảm ơn bạn đã đánh giá sản phẩm này");
                } else {
                    return redirect()->back()->with('status', "Bạn không thể đánh giá sản phẩm khi chưa mua sản phẩm này");
                }
            }else {
                return redirect()->back()->with('status', "The link you followed was broken");
            }
            return redirect()->back()->with('status', "Thank you for writing a review");
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
}
?>

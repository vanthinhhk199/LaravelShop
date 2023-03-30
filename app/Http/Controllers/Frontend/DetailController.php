<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function show($prod_id)
    {
        if (Product::where('id', $prod_id)->exists())
        {
            $categories = Category::all();
            $product = Product::all();
            $products = Product::where('id', $prod_id)->first();
            $ratings = Rating::where('prod_id', $products->id)->get();
            $rating_sum = Rating::where('prod_id', $products->id)->sum('stars_rated');
            $user_rating = Rating::where('prod_id', $products->id)->where('user_id', Auth::id())->first();
            $reviews = Review::where('prod_id', $products->id)->orderBy('created_at', 'desc')->paginate(2);
            $review = Review::where('prod_id', $products->id)->orderBy('created_at', 'desc')->get();
            if ($ratings->count() > 0) {

                $rating_value = $rating_sum/$ratings->count();
            }else{
                $rating_value = 0;
            }
            return view('frontend.products.view', compact('products', 'categories', 'product', 'ratings', 'rating_value', 'user_rating', 'reviews', 'review'));
        }else{
            return redirect('/')->with('status', 'Liên kết đã bị hỏng');
        }
    }

    public function store(Request $request)
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

    public function load_more_cmt(Request $request, $prod_id){

        $data = $request->all();

        $products = Product::where('id', $prod_id)->first();

        if ($data['id']>0){
            $reviews = Review::where('prod_id', $products->id)
                ->where('id','<',$data['id'])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }else{
            $reviews = Review::where('prod_id', $products->id)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }

        $output = '';
        if (!$reviews->isEmpty()){
            foreach($reviews as $key =>$rev){
                $last_id = $rev->id;
                $output.='<div class="media mb-4">
                            <img src="'.url('public/assets/uploads/batman.png').'" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                            <div class="media-body">
                                <h6>'.$rev->user->name.'<small> - <i>'.$rev->created_at->format('d M Y').'</i></small></h6>
                                <div class="text-primary mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <p><p>'.$rev->user_review.'</p></p>
                            </div>
                        </div>';
            }
            $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-primary form-control" data-id="'.$last_id.'" id="load_more_button">Tải Thêm</button>
                </div>
            ';
        }else{
            $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-primary form-control">Dữ liệu đang cập nhật thêm...</button>
                </div>
            ';
        }
        echo $output;
    }


}

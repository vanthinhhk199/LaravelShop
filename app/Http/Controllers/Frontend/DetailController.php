<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
}

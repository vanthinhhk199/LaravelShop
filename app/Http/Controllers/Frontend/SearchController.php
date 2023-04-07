<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProduct(Request $request)
    {
        try {
            if ($request->search) {
                $categories = Category::all();
                $searchProduct = Product::where("name","LIKE","%$request->search%")->latest()->paginate(8);
                foreach ($searchProduct as $prod) {

                    $ratings = Rating::where('prod_id', $prod->id)->get();
                    $rating_sum = Rating::where('prod_id', $prod->id)->sum('stars_rated');
                    if ($ratings->count() != 0) {
                        $prod->rating_SVG = $rating_sum/$ratings->count();
                    } else {
                        $prod->rating_SVG = 0;
                    }
                    $prod->prod_rating = $ratings->count();
                }
                return view('frontend.products.search', compact('searchProduct','categories'));
            }else{
                return redirect()->back()->with('message','Empty Search');
            }
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
}

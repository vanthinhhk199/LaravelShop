<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\ArrayList;
use PHPUnit\Framework\Constraint\Count;

class FrontendController extends Controller
{
    public function index()
    {
        // $featured_products = Product::where('trending', '1')->paginate(8);
        try {
            $featured_products = Product::where('trending', '1')
            ->leftjoin('ratings', 'products.id', '=', 'ratings.prod_id')
            ->orderBy('products.id')
            ->paginate(8);
            $products = array();
            $idProduct = '';
            $product = null;
            $count = 1;
            $index = 0;
            foreach ($featured_products as $prod) {
                if (!empty($idProduct) && $idProduct != $prod->id) {
                    if (!empty($product)) {
                        $product -> rating_SVG = $product -> rating_SVG/$count;
                        if (empty($product -> rating_SVG) || $product -> rating_SVG == 0) {
                            $product -> count = 0;
                        } else {
                            $product -> count = $count;
                        }

                    }
                    array_push($products, $product);
                    $product = $prod;

                    $product -> rating_SVG = $prod-> stars_rated;
                    $count = 1;
                } else {
                    if (empty($product)) {
                        $product = $prod;
                        $product -> rating_SVG = $prod-> stars_rated;
                    } else {

                        $prod -> rating_SVG = $product->rating_SVG + $prod->stars_rated;
                        $product = $prod;
                        $count++;
                    }

                }
                $idProduct = $prod->id;
            }
            array_push($products, $product);
            // dd($products);

            $categories = Category::all();

            foreach ($featured_products as $prod) {

                $ratings = Rating::where('prod_id', $prod->id)->get();
                $rating_sum = Rating::where('prod_id', $prod->id)->sum('stars_rated');
                if ($ratings->count() != 0) {
                    $prod->rating_SVG = $rating_sum/$ratings->count();
                } else {
                    $prod->rating_SVG = 0;
                }
                $prod->prod_rating = $ratings->count();
            }


            foreach ($categories as $category) {
                $product_count = Product::where('cate_id', $category->id)->get()->count();
                $category->cout_product = $product_count;
            }

            return view('frontend.index', compact('featured_products', 'categories'));
            
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function viewcategory($id)
    {
        try {
            if (Category::where('id', $id)->exists())
            {
                $categories = Category::all();
                $category = Category::where('id',$id)->first();
                $products = Product::where('cate_id', $category->id)->where('status','0')->get();
    
                return view('frontend.products.index', compact('category','products', 'categories'));
            }else {
                return redirect('/')->with('status',"Slug doesnot exists");
            }
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function productview($prod_id)
    {
        try {
            if (Product::where('id', $prod_id)->exists())
            {
                $categories = Category::all();
                $product = Product::all();
                $products = Product::where('id', $prod_id)->first();
                $ratings = Rating::where('prod_id', $products->id)->get();
                $rating_sum = Rating::where('prod_id', $products->id)->sum('stars_rated');
                $user_rating = Rating::where('prod_id', $products->id)->where('user_id', Auth::id())->first();
                $reviews = Review::where('prod_id', $products->id)->orderBy('created_at', 'desc')->paginate(2);
                $review = Review::all();
                if ($ratings->count() > 0) {
    
                    $rating_value = $rating_sum/$ratings->count();
                }else{
                    $rating_value = 0;
                }
                return view('frontend.products.view', compact('products', 'categories', 'product', 'ratings', 'rating_value', 'user_rating', 'reviews', 'review'));
            }else{
                return redirect('/')->with('status', 'Liên kết đã bị hỏng');
            }
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

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
?>


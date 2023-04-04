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

    public function pagination(Request $request){
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

        return view('frontend.pagination_products', compact('featured_products'))->render();
    }

    public function sort_by(Request $request) {
        $sort = $request->input('sort_by');
        $sort_price = $request->input('sort_price');

        switch ($sort) {
            case 'decrease':
                $orderBy = 'DESC';
                break;
            case 'ascending':
                $orderBy = 'ASC';
                break;
            default:
                $orderBy = 'ASC';
                break;
        }

        switch ($sort_price) {
            case 'all':
                $priceRange = [0, 999999999];
                break;
            case '0-500':
                $priceRange = [0, 500];
                break;
            case '500-1000':
                $priceRange = [500, 1000];
                break;
            case '1000-2000':
                $priceRange = [1000, 2000];
                break;
            default:
                $priceRange = [0, 999999999];
                break;
        }

        $featured_products = Product::where('trending', '1')
            ->leftJoin('ratings', 'products.id', '=', 'ratings.prod_id')
            ->whereBetween('selling_price', $priceRange)
            ->orderBy('selling_price', $orderBy)
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

        return view('frontend.products.filterProduct', compact('featured_products'))->render();
    }
}
?>


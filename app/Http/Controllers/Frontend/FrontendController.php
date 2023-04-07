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
            return response()->view('layouts.404', ['error' => 'Không thể kết nối tới database'], 500);
        }
    }

    public function viewcategory($slug)
    {
        try {
            if (Category::where('slug', $slug)->exists())
            {
                $categories = Category::all();
                $category = Category::where('slug',$slug)->first();
                $products = Product::where('cate_id', $category->id)->where('status','0')->get();

                return view('frontend.products.index', compact('category','products', 'categories'));
            }else {
                return redirect('/')->with('status',"Slug doesnot exists");
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
                $orderBy = 'DESC';
                break;
        }

        switch ($sort_price) {
            case 'all':
                $priceRange = [0, 9999999999];
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

//public function index()                       | Hàm xử lý khi user truy cập vào trang xem danh sách
//public function show($id)                     | Hàm xử lý khi user truy cập vào trang xem chi tiết 1 record
//public function store(Request $request)       | Hàm xử lý khi user gửi dữ liệu thông qua form và lưu dữ liệu vào database
//public function create()                      | Hàm xử lý khi user truy cập vào trang hiển thị form để tạo mới record
//public function edit($id)                     | Hàm xử lý khi user truy cập vào trang hiển thị form để sửa thông tin record
//public function update(Request $request, $id) | Hàm xử lý khi user gửi dữ liệu thông qua form để cập nhật record vào database
//public function destroy($id)                  | Hàm xử lý khi user yêu cầu xóa record
?>


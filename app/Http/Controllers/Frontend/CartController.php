<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Psy\Util\Json;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $prod_id = $request->input('prod_id');
        $prod_qty = $request->input('prod_qty');

        if ($prod_qty <= 0){
            return response()->json(['status' => 'Số lượng sản phẩm không thể âm']);
        }
        if ($prod_qty > 10){
            return response()->json(['status' => 'Số lượng sản phẩm không thể lớn hơn 10']);
        }

        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
        }
        else
        {
            $cart_data = array();
        }

        $item_id_list = array_column($cart_data, 'item_id');
        $prod_id_is_there = $prod_id;

        if(in_array($prod_id_is_there, $item_id_list))
        {
            foreach($cart_data as $keys => $values)
            {
                if($cart_data[$keys]["item_id"] == $prod_id)
                {
                    $cart_data[$keys]["item_quantity"] += $prod_qty;
                    $item_data = json_encode($cart_data);
                    $minutes = 60;
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                    return response()->json(['status'=>'"'.$cart_data[$keys]["item_name"].'" Already Added to Cart']);
                }
            }
        }
        else {
            $products = Product::find($prod_id);
            $prod_name = $products->name;
            $prod_image = $products->image;
            $price = $products->selling_price;

            if ($products) {
                $item_array = array(
                    'item_id' => $prod_id,
                    'item_name' => $prod_name,
                    'item_quantity' => $prod_qty,
                    'item_price' => $price,
                    'item_image' => $prod_image
                );
                $cart_data[] = $item_array;

                $item_data = json_encode($cart_data);
                $minutes = 60;
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                return response()->json(['status' => '"' . $prod_name . '" Added to Cart']);
            }
        }
    }

    public function cartloadbyajax()
    {
        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
            $totalcart = count($cart_data);

            echo json_encode(array('totalcart' => $totalcart)); die;
            return;
        }
        else
        {
            $totalcart = "0";
            echo json_encode(array('totalcart' => $totalcart)); die;
            return;
        }
    }

    public function viewcart()
    {
        $categories = Category::all();

        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);
        return view('frontend.cart', compact('categories'))
            ->with('cart_data',$cart_data);
    }

    public function updatetocart(Request $request)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);

            $item_id_list = array_column($cart_data, 'item_id');
            $prod_id_is_there = $prod_id;

            if(in_array($prod_id_is_there, $item_id_list))
            {
                foreach($cart_data as $keys => $values)
                {
                    if($cart_data[$keys]["item_id"] == $prod_id)
                    {
                        $cart_data[$keys]["item_quantity"] =  $quantity;
                        $ttprice = ($cart_data[$keys]["item_price"] * $quantity);
                        $grandtotalprice = number_format($ttprice);
                        $item_data = json_encode($cart_data);
                        $minutes = 60;
                        Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                        return response()->json([
                            'status'=>'"'.$cart_data[$keys]["item_name"].'" Quantity Updated',
                            'gtprice'=>''.$grandtotalprice.''

                        ]);
                    }
                }
            }
        }
    }

    public function deletefromcart(Request $request)
    {
        $prod_id = $request->input('product_id');

        $cookie_data = stripslashes(Cookie::get('shopping_cart')); //Lấy giá trị của cookie shopping_cart và gán vào biến $cookie_data. Hàm stripslashes được sử dụng để loại bỏ các ký tự backslash () được thêm vào trước các ký tự đặc biệt trong chuỗi, để tránh lỗi khi giải mã JSON.
        $cart_data = json_decode($cookie_data, true); // Giải mã JSON từ chuỗi $cookie_data và lưu kết quả vào biến $cart_data dưới dạng mảng.

        $item_id_list = array_column($cart_data, 'item_id'); //Tạo một mảng $item_id_list chứa các giá trị của trường item_id từ mảng $cart_data.

        $prod_id_is_there = $prod_id;

        if(in_array($prod_id_is_there, $item_id_list)) // Kiểm tra nếu giá trị của $prod_id_is_there có trong mảng $item_id_list thì thực hiện các câu lệnh bên trong.
        {
            foreach($cart_data as $keys => $values) //Lặp qua từng phần tử của mảng $cart_data, lưu index vào biến $keys và giá trị vào biến $values.
            {
                if($cart_data[$keys]["item_id"] == $prod_id)
                {
                    unset($cart_data[$keys]); //Xoá phần tử hiện tại của mảng $cart_data.
                    $item_data = json_encode($cart_data); //Chuyển đổi mảng $cart_data thành chuỗi JSON và lưu kết quả vào biến $item_data.
                    $minutes = 60; //Thiết lập thời gian sống của cookie shopping_cart là 60 phút.
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes)); //Tạo một cookie shopping_cart mới với giá trị là chuỗi JSON trong biến $item_data và thời gian sống là $minutes, và đưa cookie vào hàng đợi để gửi về máy khách sau khi HTTP response được gửi đi.
                    return response()->json(['status'=>'Item Removed from Cart']);
                }
            }
        }

    }

    public function clearcart()
    {
        Cookie::queue(Cookie::forget('shopping_cart'));
        return response()->json(['status'=>'Your Cart is Cleared']);
    }


    public function cartcount()
    {
        $cartcount = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $cartcount]);
    }
}
?>

<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);
        return view('frontend.checkout', compact('categories'))
            ->with('cart_data',$cart_data);
    }

    public function placeorder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'fname'=>' required',
                'lname'=>' required',
                'email'=>' required',
                'phone'=>' required',
                'address1'=>' required',
                'address2'=>' required',
                'city'=>' required',
                'state'=>' required',
                'country'=>' required',
                'pincode'=>' required',

            ], [
                'fname.required' => 'Vui lòng nhập First Name',
                'lname.required' => 'Vui lòng nhập Last Name',
                'email.required' => 'Vui lòng nhập Email',
                'phone.required' => 'Vui lòng nhập Phone',
                'address1.required' => 'Vui lòng nhập Address1',
                'address2.required' => 'Vui lòng nhập Address2',
                'city.required' => 'Vui lòng nhập City',
                'state.required' => 'Vui lòng nhập State',
                'country.required' => 'Vui lòng nhập Country',
                'pincode.required' => 'Vui lòng nhập Pincode',

            ]);

            if ($validator->fails()) {
                return redirect('checkout')->withErrors($validator)->withInput();
            }else{
                $order = new Order();
                $order->user_id = Auth::id();
                $order->fname = $request->input('fname');
                $order->lname = $request->input('lname');
                $order->email = $request->input('email');
                $order->phone = $request->input('phone');
                $order->address1 = $request->input('address1');
                $order->address2 = $request->input('address2');
                $order->city = $request->input('city');
                $order->state = $request->input('state');
                $order->country = $request->input('country');
                $order->pincode = $request->input('pincode');

                $order->payment_mode = $request->input('payment_mode');
                $order->payment_id = $request->input('payment_id');

                if ($request->input('payment_mode') == "Paid by Paypal"){
                    $order->status = 1;
                }
                //Tính tổng giá
                $total = 0;
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart_data = json_decode($cookie_data, true);
                $total_in_cart = $cart_data;
                foreach($total_in_cart as $prod)
                {
                    $total += $prod['item_price'] * $prod['item_quantity'];
                }

                $order->total_price = $total;

                $order->tracking_no = 'DVT'.rand(1111,9999);
                $order->save();

                $items_in_cart = $cart_data;

                foreach($items_in_cart as $item){

                    $products = Product::find($item['item_id']);
                    $prod_price = $products->selling_price;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'prod_id' => $item['item_id'],
                        'qty' => $item['item_quantity'],
                        'price' => $prod_price,

                    ]);

                    $prod = Product::where('id', $item['item_id'])->first();
                    if ($prod->qty >= $item['item_quantity']) {
                        $prod->qty = $prod->qty - $item['item_quantity'];
                        $prod->update();
                    } else {

                        //lấy ra tên sản phẩm và xoá nó khỏi cookie cart
                        $id_prod = $item['item_id'];
                        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                        $shopping_cart = json_decode($cookie_data, true);
                        $name_prod = '';

                        foreach ($shopping_cart as $item) {
                            if ($item['item_id'] == $id_prod) {
                                $name_prod = $item['item_name'];
                                break;
                            }
                        }

                        foreach($items_in_cart as $key => $item_prod) {
                            if ($item_prod['item_id'] == $id_prod) {
                                unset($items_in_cart[$key]);
                                Cookie::queue(Cookie::make('shopping_cart', json_encode($items_in_cart), 60)); //sau khi xoá cập nhật lại cart
                            }
                        }
                        //End

                        return redirect('/cart')->with('status_er', "Sản phẩm $name_prod đã hết hàng");
                    }
                }

                if(Auth::user()->address1 == NULL){

                    $user = User::where('id', Auth::id())->first();
                    $user->lname = $request->input('lname');
                    $user->phone = $request->input('phone');
                    $user->address1 = $request->input('address1');
                    $user->address2 = $request->input('address2');
                    $user->city = $request->input('city');
                    $user->state = $request->input('state');
                    $user->country = $request->input('country');
                    $user->pincode = $request->input('pincode');
                    $user->update();
                }

                Cookie::queue(Cookie::forget('shopping_cart'));

                if ($request->input('payment_mode') == "Paid by Paypal")
                {
                    return response()->json(['status' => "Order placed Successfully"]);
                }

                return redirect('/')->with('status', "Order placed Successfully");
            }
        } catch (Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }


    }

}
?>

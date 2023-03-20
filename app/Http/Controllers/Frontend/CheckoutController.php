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
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            $old_cartitems = Cart::where('user_id', Auth::id())->get();
            foreach($old_cartitems as $item){
                if(!Product::where('id', +$item->prod_id)->where('qty','>=', +$item->prod_qty)->exists()){
                    $removeItem = Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->first();
                    $removeItem->delete();
                }
            }
            $cartitems = Cart::where('user_id', Auth::id())->get();

            return view('frontend.checkout', compact('cartitems', 'categories'));
        } catch (Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
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
    
                //Tính tổng giá
                $total = 0;
                $cartitems_total = Cart::where('user_id', Auth::id())->get();
                foreach($cartitems_total as $prod)
                {
                    $total +=$prod->products->selling_price * $prod->prod_qty;
                }
    
                $order->total_price = $total;
    
                $order->tracking_no = 'DVT'.rand(1111,9999);
                $order->save();
    
                $cartitems = Cart::where('user_id', Auth::id())->get();
                foreach($cartitems as $item){
    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'prod_id' => $item->prod_id,
                        'qty' => $item->prod_qty,
                        'price' => $item->products->selling_price,
    
                    ]);
    
                    $prod = Product::where('id', $item->prod_id)->first();
                    $prod->qty = $prod->qty - $item->prod_qty;
                    $prod->update();
                }
    
                if(Auth::user()->address1 == NULL){
    
                    $user = User::where('id', Auth::id())->first();
                    $user->name = $request->input('name');
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
    
                $cartitems = Cart::where('user_id', Auth::id())->get();
                Cart::destroy($cartitems);
    
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

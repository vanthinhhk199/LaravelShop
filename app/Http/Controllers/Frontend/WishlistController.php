<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class   WishlistController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $wishlist = Wishlist::where('user_id', Auth::id())->get();
        return view('frontend.wishlist', compact('wishlist', 'categories'));
    }

    public function add(Request $request)
    {
        try {

            $prod_id = $request->input('product_id');

            if(Auth::check())
            {
                if(Wishlist::where('prod_id',$prod_id)->where('user_id',Auth::id())->exists())
                {
                    return response()->json(['status' => "sản phẩm đã tồn tại trong Wishlist", 'success' => false]);
                    
                }else{
                    
                    $wish = new Wishlist();
                    $wish->prod_id = $prod_id;
                    $wish->user_id = Auth::id();
                    $wish->save();
                    return response()->json(['status' => "Product Added Wishlist", 'success' => true]);

                }
            }else{

                return response()->json(['status' => "Login to Continue"]);

            }
        } catch (Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function deleteitem(Request $request)
    {
        try {
            if(Auth::check()){

                $prod_id = $request->input('prod_id');
                if(Wishlist::where('prod_id', $prod_id)->where('user_id',Auth::id())->exists()){
                    $wish = Wishlist::where('prod_id', $prod_id)->where('user_id',Auth::id())->first();
                    $wish->delete();
                    return response()->json(['status' => "Đã xoá khỏi Wishlist"]);
                }
            }else{
                return response()->json(['status' => "Login to Continue"]);
            }
        } catch (Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }

    public function wishlistcount()
    {
        $wishcount = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $wishcount]);
    }
}
?>
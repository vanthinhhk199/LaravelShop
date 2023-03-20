<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            $orders = Order::where('user_id', Auth::id())->get();
            return view('frontend.orders.index', compact('orders','categories'));

        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
    public function view($id)
    {
        try {
            $categories = Category::all();
            $orders = Order::where('id',$id)->where('user_id', Auth::id())->first();
            return view('frontend.orders.view', compact('orders', 'categories'));
        } catch (\Exception $e) {
            return response()->view('layouts.404', ['error' => $e->getMessage()], 500);
        }
    }
}
?>

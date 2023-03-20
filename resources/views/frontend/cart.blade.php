@extends('layouts.front')

@section('title')
    Cart
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="/">Home</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="cartitems">
            <div class="row px-xl-5">
                <div class="col-lg-8 table-responsive mb-5">
                    @php
                        $total = 0;
                    @endphp
                    @if ($cartitems->count() > 0)
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <th>
                                <th>Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($cartitems as $item)
                                <tr class="product_data">
                                    <td class="d-flex">
                                        <img src="{{ asset('assets/uploads/products/'.$item->products->image) }}" alt="" style="width: 50px;">
                                    </td>
                                    <td>
                                        <p>
                                            {{ $item->products->name }}
                                        </p>
                                    </td>
                                    <td class="align-middle">{{ $item->products->selling_price }}</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 130px;">
                                            <input type="hidden"  class="prod_id" value="{{ $item->prod_id }}">
                                            @if ($item->products->qty >= $item->prod_qty)
                                                <div class="input-group text-center mr-3" style="width: 130px">
                                                    <button class="btn btn-primary changeQuantity decrement-btn">-</button>
                                                    <input type="text" name="quantity" class="form-control qty-input text-center" value="{{ $item->prod_qty }}">
                                                    <button class="btn btn-primary changeQuantity increment-btn">+</button>
                                                </div>
                                            @else
                                                <h6 class="ml-4 text-danger">Hết hàng</h6>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ $item->products->selling_price * $item->prod_qty }}</td>
                                    <td class="align-middle"><button class="btn btn-sm btn-danger delete-cart-item"><i class="fa fa-times"></i></button></td>
                                </tr>
                                @php
                                    $total += $item->products->selling_price * $item->prod_qty;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="card-body text-center mt-5">
                                <h2>Your <i class="fa fa-shopping-cart"></i> Cart is empty</h2>
                                <a href="{{ url('/') }}" class="btn btn-outline-primary float-end">Continue Shopping</a>
                            </div>
                        @endif
                </div>
                <div class="col-lg-4">
                    <form class="mb-30" action="">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Apply Coupon</button>
                            </div>
                        </div>
                    </form>
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6>$150</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">$10</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5>{{  $total }}</h5>
                            </div>
                            <a href="{{ url('checkout') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    @endsection

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
                    @php $total= 0; @endphp
                    @if(isset($cart_data))
                        @if(Cookie::get('shopping_cart'))
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
                                <tbody>
                                @foreach ($cart_data as $data)
                                    <tr class="cartpage">
                                        <td class="d-flex">
                                            <img src="{{ asset('assets/uploads/products/'.$data['item_image']) }}" alt="" style="width: 50px;">
                                        </td>
                                        <td>
                                            <p>
                                                {{ $data['item_name'] }}
                                            </p>
                                        </td>
                                        <td class="align-middle">{{ $data['item_price'] }} $</td>
                                        <td class="align-middle">
                                            <div class="input-group mx-auto" style="width: 130px;">
                                                <input type="hidden" class="product_id" value="{{ $data['item_id'] }}" >
                                                <div class="input-group text-center mr-3 product_data" style="width: 130px">
                                                    <button class="btn btn-primary decrement-btn changeQuantity">-</button>
                                                    <input id="myInput" type="text" readonly="readonly" min="1" step="1" class="form-control qty-input text-center" value="{{ $data['item_quantity'] }}"  >
                                                    <button class="btn btn-primary increment-btn changeQuantity">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle cart-grand-total-price">{{ $data['item_quantity'] * $data['item_price'] }}</td>
                                        <td class="align-middle"><button class="btn btn-sm btn-danger delete_cart_data"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    @php
                                        $total += ($data['item_quantity'] * $data['item_price']);
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        @endif
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
                        <div id="totalajaxcall" class="border-bottom pb-2">
                            <div class="totalpricingload">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6>$150</h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-medium">Shipping</h6>
                                    <h6 class="font-weight-medium">$10</h6>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-2">
                                    <h5>Total</h5>
                                    <h5>{{  $total }} $</h5>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <a href="{{ url('checkout') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

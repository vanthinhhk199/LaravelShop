@extends('layouts.front')

@section('title')
    My Cart
@endsection

@section('content')

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Wishlist</a>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<div class="container-fluid">
    <div class="card shadow wishlistitems" style="margin: 0 46px">
        <div class="cart-body">
            @if ($wishlist->count() > 0 )
            <div class="card-body">
                @foreach ($wishlist as $item)
                    <div class="row product_data cart-wl">
                        <div class="col-md-2">
                            <img src="{{ asset('assets/uploads/products/'.$item->products->image) }}" height="70px" width="70px" alt="Image">
                        </div>
                        <div class="col-md-4">
                            <h6 class="cart-wl-h">{{ $item->products->name }}</h6>
                        </div>
                        <div class="col-md-2">
                            <h6 class="cart-wl-h">{{ $item->products->selling_price }}</h6>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden" class="prod_id" value="{{ $item->prod_id }}">
                            @if ($item->products->qty >= $item->prod_qty)
                                <div class="input-group text-center" style="width: 130px">
                                    <button class="input-group-text decrement-btn">-</button>
                                    <input type="text" name="quantity"  class="form-control qty-input text-center" value="1">
                                    <button class="input-group-text increment-btn">+</button>
                                </div>
                            @else
                                <h6>Out of Stock</h6>
                            @endif

                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-success addToCartBtn"><i class="fa fa-shopping-cart"></i></button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger remove-wishlist-item"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <h4>There are products in your Wishlist</h4>
            @endif
        </div>
    </div>
</div>

@endsection

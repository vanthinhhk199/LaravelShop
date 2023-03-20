@extends('layouts.front')

@section('title')
    Welcome to T-Shop
@endsection

@section('content')
    @include('layouts.inc.slider')

    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach ($categories as $cate)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="{{ url('view-category/'.$cate->id) }}">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="{{ asset('assets/uploads/category/'.$cate->image) }}" alt="">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{ $cate->name }}</h6>
                                <small class="text-body">{{ $cate->cout_product }} Products</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
        <div class="row px-xl-5">


            @foreach ($featured_products as $prod)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 img-prod" src="{{ asset('assets/uploads/products/'.$prod->image) }}" alt="Product image">
                            <div class="product-action">
                                {{-- <a class="btn btn-outline-dark btn-square" href="{{ url('cart') }}"><i class="fa fa-shopping-cart"></i></a> --}}
                                <a class="btn btn-outline-dark btn-square" href="{{ url('product/'.$prod->id) }}"><i class="fa fa-search"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ url('product/'.$prod->id) }}">{{ $prod->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$ {{ number_format($prod->selling_price, 2) }}</h5><h6 class="text-muted ml-2"><del>$ {{ number_format($prod->original_price, 2) }}</del></h6>
                            </div>

                            <div class="d-flex align-items-center justify-content-center mb-1">
                                {{-- <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small> --}}

                                @php $ratenum = number_format($prod->rating_SVG) @endphp
                                <div class="rating">

                                    @for ($i = 1; $i<= $ratenum; $i++ )
                                        <i class="fa fa-star checked text-warning"></i>
                                    @endfor

                                    @for ($j = $ratenum+1; $j <= 5; $j++)
                                        <i class="fa fa-star"></i>
                                    @endfor

                                    <span>
                                        @if ($prod->prod_rating > 0)
                                            {{ $prod->prod_rating }} Ratings
                                        @else
                                            No Ratings
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="paginationWrap">
        @if (isset($featured_products) && count($featured_products)> 0)
            {{ $featured_products->links() }}
        @endif
    </div>
    <!-- Products End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

@endsection

@extends('layouts.front')

@section('title')
    Welcome to T-Shop
@endsection

@section('content')
    @include('layouts.inc.slider')

    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">DANH MỤC</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach ($categories as $cate)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="{{ url('view-category/'.$cate->slug) }}">
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
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">SẢN PHẨM</span></h2>
            <div class="d-flex form-filter">
                <div class="px-xl-5 d-flex">
                    <label class="form-filter-lable mr-2" for="price_range">Giá:</label>
                    <select class="form-filter-select" name="sort-price" id="sort_price">
                        <option value="all">Tất cả giá</option>
                        <option value="0-500">Dưới 500</option>
                        <option value="500-1000">Từ 500-1000</option>
                        <option value="1000-2000">Từ 1000-2000</option>
                        <option value="2000-5000">Từ 2000-5000</option>
                        <option value="20000-">Trên 20000</option>
                    </select>
                </div>
                <div class=" d-flex">
                    <label class="form-filter-lable mr-2" for="brand">Hãng:</label>
                    <select class="form-filter-select" name="sort_by" id="sort_by">
                        <option value="">Sắp Xếp</option>
                        <option value="decrease">Giá giảm dần</option>
                        <option value="ascending">Giá tăng dần</option>
                    </select>
                </div>
            </div>
        <div class="table-prod">
            <div class="row px-xl-5">
                @foreach ($featured_products as $prod)
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <a href="{{ url('product/'.$prod->id) }}">
                                    <img class="img-fluid w-100 img-prod" src="{{ asset('assets/uploads/products/'.$prod->image) }}" alt="Product image">
                                </a>
{{--                                <div class="product-action">--}}
{{--                                     <a class="btn btn-outline-dark btn-square" href="{{ url('cart') }}"><i class="fa fa-shopping-cart"></i></a>--}}
{{--                                    <a class="btn btn-outline-dark btn-square" href="{{ url('product/'.$prod->id) }}"><i class="fa fa-search"></i></a>--}}
{{--                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>--}}
{{--                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>--}}
{{--                                </div>--}}
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="{{ url('product/'.$prod->id) }}">{{ $prod->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$ {{ number_format($prod->selling_price, 2) }}</h5><h6 class="text-muted ml-2"><del>$ {{ number_format($prod->original_price, 2) }}</del></h6>
                                </div>

                                <div class="d-flex align-items-center justify-content-center mb-1">
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
            <div class="paginationWrap">
                @if (isset($featured_products) && count($featured_products)> 0)
                    {{ $featured_products->links() }}
                @endif
            </div>
        </div>
    </div>

    <!-- Products End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

@endsection

@section('scripts')
    <script src="{{ asset('frontend/js/pagination.js') }}"></script>
@endsection

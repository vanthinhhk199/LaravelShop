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

@extends('layouts.front')

@section('title')
    Product detail
@endsection

@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ url('/') }}">Home</a>
                    <span class="breadcrumb-item active">{{ $products->category->name }}</span>
                    <span class="breadcrumb-item active">{{ $products->name }}</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5 product_data">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100" src="{{ asset('assets/uploads/products/'.$products->image) }}" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $products->name }}</h3>
                    <div class="d-flex mb-3">
                        @php $ratenum = number_format($rating_value) @endphp
                        <div class="rating">

                            @for ($i = 1; $i<= $ratenum; $i++ )
                                <i class="fa fa-star checked text-warning"></i>
                            @endfor

                            @for ($j = $ratenum+1; $j <= 5; $j++)
                                <i class="fa fa-star"></i>
                            @endfor

                            <span>
                                @if ($ratings->count() > 0)
                                    {{ $ratings->count( ) }} Ratings
                                @else
                                    No Ratings
                                @endif
                            </span>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal">
                            Rating
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ url('/add-rating') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $products->id }}">
                                        <div class="modal-header">
                                            <h4 class="modal-title fs-5" id="exampleModalLabel">Rate {{ $products->name }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="rating-css">
                                                <div class="star-icon">
                                                    @if ($user_rating)

                                                        @for ($i = 1; $i<= $user_rating->stars_rated; $i++ )
                                                            <input type="radio" value="{{ $i }}" name="product_rating" checked id="rating{{ $i }}">
                                                            <label for="rating{{ $i }}" class="fa fa-star"></label>
                                                        @endfor

                                                        @for ($j = $user_rating->stars_rated+1; $j <= 5; $j++)
                                                            <input type="radio" value="{{ $j }}" name="product_rating" id="rating{{ $j }}">
                                                            <label for="rating{{ $j }}" class="fa fa-star"></label>
                                                        @endfor

                                                    @else
                                                        <input type="radio" value="1" name="product_rating" checked id="rating1">
                                                        <label for="rating1" class="fa fa-star"></label>
                                                        <input type="radio" value="2" name="product_rating" id="rating2">
                                                        <label for="rating2" class="fa fa-star"></label>
                                                        <input type="radio" value="3" name="product_rating" id="rating3">
                                                        <label for="rating3" class="fa fa-star"></label>
                                                        <input type="radio" value="4" name="product_rating" id="rating4">
                                                        <label for="rating4" class="fa fa-star"></label>
                                                        <input type="radio" value="5" name="product_rating" id="rating5">
                                                        <label for="rating5" class="fa fa-star"></label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($products->qty > 0)
                        <label class="badge bg-success text-white">Còn hàng</label>
                    @else
                        <label class="badge bg-danger text-white">Hết hàng</label>
                    @endif
                    <h3 class="font-weight-semi-bold mb-4">Price: {{ $products->selling_price }} $</h3>
                    <p class="mb-4">{{ $products->small_description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <input type="hidden" value="{{ $products->id }}" class="prod_id">
                        <div class="input-group text-center mr-3" style="width: 130px">
                            <button class="btn btn-primary changeQuantity decrement-btn">-</button>
                            <input type="text" name="quantity" class="form-control qty-input text-center" value="1">
                            <button class="btn btn-primary changeQuantity increment-btn">+</button>
                        </div>
                        @if ($products->qty > 0)
                            <button class="btn btn-primary addToCartBtn px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                        @endif
                        <button class="btn btn-info px-3 addToWishlist ml-2"><i class="fa fa-heart mr-1"></i> Add Wishlist</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-3">Reviews ({{ $review->count() }})</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p>{{ $products->description }}</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  show active" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">{{ $review->count() }} review for "{{ $products->name }}"</h4>
                                    @foreach ($reviews as $item)
                                        <div class="media mb-4">
                                            <img src="{{ asset('assets/uploads/batman.png') }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                            <div class="media-body">
                                                <h6>{{ $item->user->name }}<small> - <i>{{ $item->created_at->format('d M Y') }}</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <p><p>{{ $item->user_review }}</p></p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                    @if (isset($reviews) && count($reviews)> 0)
                                        {{ $reviews->links() }}
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form action="{{ url('add-review') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="prod_id" id="prod_id" value="{{ $products->id }}">
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="user_review" name="user_review" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary px-3">Gửi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($product as $prod)
                    <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100 img-prod" src="{{ asset('assets/uploads/products/'.$prod->image) }}" alt="Product image">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="{{ url('product/'.$prod->slug) }}"><i class="fa fa-search"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="{{ url('product/'.$prod->slug) }}">{{ $prod->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$ {{ number_format($prod->original_price, 2) }}</h5><h6 class="text-muted ml-2"><del>$ {{ number_format($prod->selling_price, 2) }}</del></h6>
                                </div>
                            </div>
                        </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

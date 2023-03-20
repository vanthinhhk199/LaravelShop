    <!-- Topbar Start -->
    <div class="container-fluid">
        {{-- <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">My Order</button>
                            <button class="dropdown-item" type="button">My Profile</button>
                        </div>
                    </div>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="{{ url('cart') }}" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div> --}}
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="/" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Thinh</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="{{ url('search') }}" method="GET" role="search">
                    @csrf
                    <div class="input-group">
                        <input type="search" class="form-control" value="{{ Request::get('search') }}" name="search" placeholder="Search for products">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <div class="btn-group">
                    @guest
                        @if (Route::has('login'))
                            <button type="button" class="btn btn-dark">
                                <a class="" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </button>
                        @endif

                        @if (Route::has('register'))
                            <button type="button" class="btn btn-dark ml-2">
                                <a class="" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </button>
                        @endif
                    @else
                        <button type="button" class="btn btn-sm text-black dropdown-toggle" style="font-weight: bold;" data-toggle="dropdown">{{ Auth::user()->name }}</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item clr-lg grp-lg" type="button"><a href="{{ url('my-orders') }}">My Order</a></button>
                            <button class="dropdown-item clr-lg grp-lg" type="button"><a href="">My Profile</a></button>
                            <button class="dropdown-item grp-lg" type="button">
                                <a class="dropdown-item a-logout clr-lg" style="display: block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </button>

                        </div>
                    @endguest
                </div>
            </div>

            <div id="rp-login" class="">
                <div class="navbar-nav mr-auto py-0">
                    @guest
                        @if (Route::has('login'))
                            <a class="nav-item nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))
                            <a class="nav-item nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <div class="navbar-nav mr-auto py-0 text-white" data-toggle="dropdown"><a class="clr-lg" href="">{{ Auth::user()->name }}</a></div>
                        <div class="dropdown-menu prop-lg dropdown-menu-right">
                            <div class="dropdown-item"><a class="text-white clr-lg" href="{{ url('my-orders') }}">My Order</a></div>
                            <div class="dropdown-item"><a class="text-white clr-lg" href="">My Profile</a></div>
                            <div class="dropdown-item">
                                <a class="dropdown-item a-logout text-white clr-lg" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>

                        </div>
                    @endguest
                </div>
            </div>

        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        {{-- <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                <a href="" class="dropdown-item">Men's Dresses</a>
                                <a href="" class="dropdown-item">Women's Dresses</a>
                                <a href="" class="dropdown-item">Baby's Dresses</a>
                            </div>
                        </div> --}}
                        @foreach ($categories as $cate)
                            <a href="{{ url('view-category/'.$cate->id) }}" class="nav-item nav-link">{{ $cate->name }}</a>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="{{ url("/") }}" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Thinh</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="/" class="nav-item nav-link">Home</a>
                            <a href="{{ url('cart') }}" class="nav-item nav-link">Cart</a>
                            <a href="{{ url('wishlist') }}" class="nav-item nav-link">Wishlist</a>
                            {{-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contact</a> --}}
                        </div>
                        <div id="rp-login" class="">
                            <div class="navbar-nav mr-auto py-0">
                                @guest
                                    @if (Route::has('login'))
                                        <a class="nav-item nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a class="nav-item nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                @else
                                    <div class="navbar-nav mr-auto py-0 text-white" data-toggle="dropdown"><a class="clr-lg" href="">{{ Auth::user()->name }}</a></div>
                                    <div class="dropdown-menu prop-lg dropdown-menu-right">
                                        <div class="dropdown-item"><a class="text-white clr-lg" href="{{ url('my-orders') }}">My Order</a></div>
                                        <div class="dropdown-item"><a class="text-white clr-lg" href="">My Profile</a></div>
                                        <div class="dropdown-item">
                                            <a class="dropdown-item a-logout text-white clr-lg" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>

                                    </div>
                                @endguest
                            </div>
                        </div>
                        <div class="navbar-nav py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle wishlist-count" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="{{ url('cart') }}" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle cart-count" style="padding-bottom: 2px;">0</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

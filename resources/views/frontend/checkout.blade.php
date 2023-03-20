@extends('layouts.front')

@section('title')
    Check Out
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="container-fluid">
        <form action="{{ url('place-order') }}" method="POST">
            {{ csrf_field() }}
            <div class="row px-xl-5">
                @if ($cartitems->count() > 0)
                    <div class="col-lg-8">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="row checkout-form">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input class="form-control firstname" type="text" name="fname" value="{{ Auth::user()->fname }}" placeholder="First Name">
                                    <span id="fname_error" class="text-danger"></span>
                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('fname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input class="form-control lastname" type="text" name="lname" value="{{ Auth::user()->lname }}" placeholder="Last Name">
                                    <span id="lname_error" class="text-danger"></span>
                                    @if ($errors->has('lname'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('lname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <input class="form-control email" type="text" name="email" value="{{ Auth::user()->email }}" placeholder="Email">
                                    <span id="email_error" class="text-danger"></span>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control phone" type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Phone">
                                    <span id="phone_error" class="text-danger"></span>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address Line 1</label>
                                    <input class="form-control address1" type="text" name="address1" value="{{ Auth::user()->address1 }}" placeholder="Address">
                                    <span id="address1_error" class="text-danger"></span>
                                    @if ($errors->has('address1'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('address1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address Line 2</label>
                                    <input class="form-control address2" type="text" name="address2" value="{{ Auth::user()->address2 }}" placeholder="Address">
                                    <span id="address2_error" class="text-danger"></span>
                                    @if ($errors->has('address2'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('address2') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <input class="form-control city" type="text" name="country" value="{{ Auth::user()->country }}" placeholder="Country">
                                    <span id="city_error" class="text-danger"></span>
                                    @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input class="form-control state" type="text" name="city" value="{{ Auth::user()->city }}" placeholder="City">
                                    <span id="state_error" class="text-danger"></span>
                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <input class="form-control country" type="text" name="state" value="{{ Auth::user()->state }}" placeholder="State">
                                    <span id="country_error" class="text-danger"></span>
                                    @if ($errors->has('state'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Pin Code</label>
                                    <input class="form-control pincode" type="text" name="pincode" value="{{ Auth::user()->pincode }}" placeholder="Pin Code">
                                    <span id="pincode_error" class="text-danger"></span>
                                    @if ($errors->has('pincode'))
                                        <span class="help-block">
                                            <strong style="color: red">{{ $errors->first('pincode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="border-bottom">
                                <h6 class="mb-3">Products</h6>
                                @php $total = 0 @endphp

                                @foreach ($cartitems as $item)
                                    @php $total += ($item->products->selling_price * $item->prod_qty) @endphp
                                    <div class="d-flex justify-content-between">
                                        <p>{{ $item->products->name }}</p>
                                        <p>{{ $item->prod_qty * $item->products->selling_price }} $</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-bottom pt-3 pb-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6>$0</h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-medium">Shipping</h6>
                                    <h6 class="font-weight-medium">$0</h6>
                                </div>
                            </div>
                            <div class="pt-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5>Total</h5>
                                    <h5>{{ $total }}$</h5>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                            <div class="bg-light p-30">
                                <input type="hidden" name="payment_mode" value="COD">
                                <button type="submit" class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                                <div id="paypal-button-container" class="py-2"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-body text-center mt-5">
                        <h2>Your <i class="fa fa-shopping-cart"></i> No products in cart</h2>
                        <a href="{{ url('/') }}" class="btn btn-outline-primary float-end">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </form>
    </div>
    <!-- Checkout End -->
@endsection

@section('scripts')

    <script src="https://www.paypal.com/sdk/js?client-id=AYxavrHdCLYLVUC6USfORhzyxE4KdzDrwa7Udf7vAfextpmVTK0UP1-4ToyKVDvB509M4A3rfxIOlj0w"></script>

    <script>

        paypal.Buttons({
        createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
            purchase_units: [{
                amount: {
                value: '{{ $total }}'
                },
            }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
            // This function shows a transaction success message to your buyer.
            // alert('Transaction completed by ' + details.payer.name.given_name);

            var firstname = $('.firstname').val();
            var lastname = $('.lastname').val();
            var email = $('.email').val();
            var phone = $('.phone').val();
            var address1 = $('.address1').val();
            var address2 = $('.address2').val();
            var city = $('.city').val();
            var state = $('.state').val();
            var country = $('.country').val();
            var pincode = $('.pincode').val();

            if (!firstname) {
                fname_error = "First Name is required";
                $('#fname_error').html('');
                $('#fname_error').html(fname_error);
            }else{
                fname_error = "";
                $('#fname_error').html('');
            }
            if (!lastname) {
                lastname_error = "lastname is required";
                $('#lastname_error').html('');
                $('#lastname_error').html(lastname_error);
            }else{
                lastname_error = "";
                $('#lastname_error').html('');
            }
            if (!email) {
                email_error = "email is required";
                $('#email_error').html('');
                $('#email_error').html(email_error);
            }else{
                email_error = "";
                $('#email_error').html('');
            }
            if (!phone) {
                phone_error = "phone is required";
                $('#phone_error').html('');
                $('#phone_error').html(phone_error);
            }else{
                phone_error = "";
                $('#phone_error').html('');
            }
            if (!address1) {
                address1_error = "address1 is required";
                $('#address1_error').html('');
                $('#address1_error').html(address1_error);
            }else{
                address1_error = "";
                $('#address1_error').html('');
            }
            if (!address2) {
                address2_error = "address2 is required";
                $('#address2_error').html('');
                $('#address2_error').html(address2_error);
            }else{
                address2_error = "";
                $('#address2_error').html('');
            }
            if (!city) {
                city_error = "city is required";
                $('#city_error').html('');
                $('#city_error').html(city_error);
            }else{
                city_error = "";
                $('#city_error').html('');
            }
            if (!state) {
                state_error = "state is required";
                $('#state_error').html('');
                $('#state_error').html(state_error);
            }else{
                state_error = "";
                $('#state_error').html('');
            }
            if (!country) {
                country_error = "country is required";
                $('#country_error').html('');
                $('#country_error').html(country_error);
            }else{
                country_error = "";
                $('#country_error').html('');
            }
            if (!pincode) {
                pincode_error = "pincode is required";
                $('#pincode_error').html('');
                $('#pincode_error').html(pincode_error);
            }else{
                pincode_error = "";
                $('#pincode_error').html('');
            }

            if (fname_error != '' || lastname_error != '' || email_error != '' || phone_error != '' || address1_error != '' || address2_error != '' || city_error != '' || state_error != '' || country_error != '' || pincode_error != '') {
                return false;
            }else{
                $.ajax({
                    method: "POST",
                    url: "/place-order",
                    data: {
                        'fname':firstname,
                        'lname':lastname,
                        'email':email,
                        'phone':phone,
                        'address1':address1,
                        'address2':address2,
                        'city':city,
                        'state':state,
                        'country':country,
                        'pincode':pincode,
                        'payment_mode':"Paid by Paypal",
                        'payment_id':details.id,

                    },
                    success: function (response) {
                        swal("", response.status, "success")
                        .then((value) => {
                            window.location.href = "/my-orders";
                        });
                    }
                });
            }

            });
        }
        }).render('#paypal-button-container');
        //This function displays payment buttons on your web page.

    </script>

@endsection

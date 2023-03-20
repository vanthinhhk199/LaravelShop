@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-black">Orders View
                            <a href="{{ url('my-orders') }}" class="btn bg-info text-white float-right">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>Shipping Details</h4>
                                <hr>
                                <label for="">Name: </label>
                                <span class="">{{ $orders->fname.' '.$orders->lname }}</span><br>
                                <label for="">Email: </label>
                                <span class="">{{ $orders->email }}</span><br>
                                <label for="">Contact No: </label>
                                <span class="">{{ $orders->phone }}</span><br>
                                <label for="">Address 1: </label>
                                <span class="">
                                    {{ $orders->address1 }},<br>
                                </span>
                                <label for="">Address 2: </label>
                                <span class="">
                                    {{ $orders->address2 }},<br>
                                </span>
                                <label for="">City: </label>
                                <span class="">{{ $orders->city }}</span><br>
                                <label for="">state: </label>
                                <span class="">{{ $orders->state }}</span><br>
                                <label for="">country: </label>
                                <span class="">{{ $orders->country }}</span><br>
                                <label for="">Pin Code: </label>
                                <span class="">{{ $orders->pincode }}</span>
                            </div>
                            <div class="col-md-6">
                                <h4>Order Details Details</h4>
                                <hr>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders->orderitems as $item)
                                            <tr>
                                                <td>{{ $item->products->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>
                                                    <img src="{{ asset('assets/uploads/products/'.$item->products->image) }}" width="80px" alt="Product Image">
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <h4 class="px-2">Grand Total: <span class="float-end">{{ $orders->total_price }}$</span></h4>
                                <h6 class="px-2">Payment Mode:{{ $orders->payment_mode }}$</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Products</h3>
            <hr>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Original Price</th>
                        <th>Selling</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->original_price }}</td>
                        <td>{{ $item->selling_price }}</td>

                        <td>
                            <img src="{{ asset('assets/uploads/products/'.$item->image) }}" class="cate-image" alt="Image here">
                        </td>
                        <td>
                            <a href="{{ url('edit-products/'.$item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ url('delete-products/'.$item->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $products->links() }} --}}
        </div>
    </div>
@endsection

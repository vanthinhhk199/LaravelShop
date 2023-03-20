@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add Product</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <select class="form-select" name="cate_id">
                            <option value="">Select a Category</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                        </select>
                        @if ($errors->has('cate_id'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('cate_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Slug</label>
                        <input type="text" class="form-control" name="slug">
                        @if ($errors->has('slug'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Small Description</label>
                        <textarea name="small_description" rows="3" class="form-control"></textarea>
                        @if ($errors->has('small_description'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('small_description') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Original Price</label>
                        <input type="text" class="form-control" name="original_price">
                        @if ($errors->has('original_price'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('original_price') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Selling Price</label>
                        <input type="text" class="form-control" name="selling_price">
                        @if ($errors->has('selling_price'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('selling_price') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Tax</label>
                        <input type="text" class="form-control" name="tax">
                        @if ($errors->has('tax'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('tax') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Quantily</label>
                        <input type="text" class="form-control" name="qty">
                        @if ($errors->has('qty'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('qty') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Status</label>
                        <input type="checkbox" name="status">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Trending</label>
                        <input type="checkbox" name="trending">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Meta Title</label>
                        <textarea type="text" class="form-control" name="meta_title"></textarea>
                        @if ($errors->has('meta_title'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('meta_title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Meta Keywords</label>
                        <textarea name="meta_keywords" rows="3" class="form-control"></textarea>
                        @if ($errors->has('meta_keywords'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('meta_keywords') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="form-control"></textarea>
                        @if ($errors->has('meta_description'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('meta_description') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <input type="file" name="image" class="form-control">
                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

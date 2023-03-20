@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-category') }}" method="post" enctype="multipart/form-data">
                @csrf
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
                        <label for="">Description</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Status</label>
                        <input type="checkbox" name="status">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Popular</label>
                        <input type="checkbox" name="popular">
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
                        <textarea name="meta_descrip" rows="3" class="form-control"></textarea>
                        @if ($errors->has('meta_descrip'))
                            <span class="help-block">
                                <strong style="color: red">{{ $errors->first('meta_descrip') }}</strong>
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

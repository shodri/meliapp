@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Publish a new product</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.publish') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="details" class="col-md-4 col-form-label text-md-end">Details</label>

                            <div class="col-md-6">
                                <input id="details" type="text" class="form-control" name="details" value="{{ old('details') }}" required autocomplete="details" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="stock" class="col-md-4 col-form-label text-md-end">Stock</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" min="1" class="form-control" name="stock" value="{{ old('stock') }}" required autocomplete="stock" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="picture" class="col-md-4 col-form-label text-md-end">Picture</label>

                            <div class="col-md-6">
                                <input id="picture" type="file" class="form-control" name="picture"  required autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category" class="col-md-4 col-form-label text-md-end">Category</label>

                            <div class="col-md-6">
                                <select name="category" class="form-select" id="category" required>
                                    <option selected>Choose...</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Publish
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

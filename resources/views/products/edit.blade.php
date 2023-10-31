@extends('layouts.app')

@section('content')
    <h1>Edit a Product</h1>

    <form 
        method="POST" 
        action="{{ route('products.update', ['product' => $product->id]) }}" 
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="{{ old('title') ?? $product->title}}" required>
        </div>
        <div class="form-row">
            <label>Description</label>
            <input type="text" class="form-control" name="description" value="{{ old('description') ?? $product->description}}" required>
        </div>
        <div class="form-row">
            <label>Price</label>
            <input type="number" class="form-control" min="1.00" step="0.01" name="price" value="{{  old('price') ??  $product->price}}" required>
        </div>
        <div class="form-row">
            <label>Stock</label>
            <input type="number" min="0" class="form-control" name="stock" value="{{  old('stock') ??  $product->stock}}" required>
        </div>
        <div class="form-row">
            <label>Status</label>
            <select name="status" id="">
                <option value="" selected>Select..</option>
                <option {{ old('status') == 'available' ? 'selected' : ($product->status ==  'available' ? 'selected' : '')}} value="available">Available</option>
                <option {{ old('status') == 'unavailable' ? 'selected' : ($product->status ==  'unavailable' ? 'selected' : '')}} value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="form-row">
            <label >
                {{ __('Images') }}
            </label>

            <div class="col-md-6">
                <div class="custom-file">
                    <input type="file" accept="image/*" name="images[]" class="form-control" multiple>
                </div>
            </div>
        </div>

        <div class="form-row">
            <button type="submit" class="btn btn-primary btn-large mt-3">Create Product</button>
        </div>

    </form>

@endsection

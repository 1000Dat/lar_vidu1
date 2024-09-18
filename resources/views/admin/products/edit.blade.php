@extends('admin.admin')

@section('title', 'Edit Product')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .btn-success {
            background-color: #28a745;
            border: 1px solid #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .image-preview {
            margin-bottom: 15px;
        }

        .image-preview img {
            max-width: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>

    <div class="container">
        <h2 class="page-title">Edit Product</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity }}" required min="0">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required step="0.01" min="0">
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Hiển thị ảnh sản phẩm hiện tại -->
            <div class="image-preview">
                <label>Current Image:</label><br>
                @if($product->image)
                <img src="{{ $product->image ? Storage::url($product->image) : asset('images/default-placeholder.png') }}" alt="{{ $product->name }}">
                @else
                    <p>No image available</p>
                @endif
            </div>

            <!-- Thêm trường upload ảnh mới (không bắt buộc) -->
            <div class="form-group">
                <label for="image">Upload New Image (Optional):</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection

<!-- resources/views/admin/categories/edit.blade.php -->
@extends('admin.admin')

@section('title', 'Edit Category')

@section('content')
    <h2>Edit Category</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection

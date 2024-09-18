<!-- resources/views/admin/categories/create.blade.php -->
@extends('admin.admin')

@section('title', 'Create Category')

@section('content')
    <h2>Create New Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection



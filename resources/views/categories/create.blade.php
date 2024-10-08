<!-- resources/views/categories/create.blade.php -->
@extends('categories.app')

@section('content')
<div class="container">
    <h1>Create New Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
@endsection

<!-- resources/views/admin/categories/index.blade.php -->

@extends('admin.admin')

@section('title', 'Manage Categories')

@section('content')
    <style>
        /* CSS for the category management page */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border: 1px solid #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .list-group {
            margin-top: 20px;
            padding-left: 0;
            list-style: none;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .btn-warning {
            background-color: #ffc107;
            border: 1px solid #ffc107;
            color: #212529;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border: 1px solid #dc3545;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>

    <div class="container">
        <h2 class="page-title">Category List</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $category->name }}
                    <div>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

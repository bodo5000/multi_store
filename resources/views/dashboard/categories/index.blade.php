@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='categories' main_page='categories' page='home' />
@endsection


@section('contnet')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-success">
            Create Category
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Parent</th>
                <th>created_at</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categories as $index => $category)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_id ?? 'N/A' }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->iamge ?? 'none' }}</td>
                    <td class="d-flex">
                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                            class="btn btn-sm btn-outline-primary mr-2">
                            Edit
                        </a>

                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">there is no categories yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

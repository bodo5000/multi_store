@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='categories' main_page='categories' page='trashed' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-success">
            return to categories
        </a>
    </div>

    <x-alert type="success" />
    <x-alert type="danger" />
    <x-alert type="info" />
    <x-alert type="warning" />

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-between mb-4">
        <input type="text" name="name" placeholder="serch by category name" class="form-control mx-2"
            value="{{ request('name') }}">
        <select name="status" id="" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>

        <button type="submit" class="btn btn-dark mx-2">filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Parent</th>
                <th>status</th>
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
                    <td>{{ $category->parent_name ?? 'N/A' }}</td>
                    <td class="badge {{ $category->status == 'active' ? 'bg-green' : 'bg-danger' }}">{{ $category->status }}
                    </td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="image" height="30">
                    </td>
                    <td class="d-flex">

                        <form class="mx-2" action="{{ route('dashboard.categories.restore', $category->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-success">restore</button>
                        </form>

                        <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="POST">
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

    {{ $categories->withQueryString()->links() }}
@endsection

@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title="category name: {{ $category->name }}" main_page='categories' page='category_info' />
@endsection

@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-success">
            BackToCategories
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>product Name</th>
                <th>store</th>
                <th>status</th>
                <th>created_at</th>
            </tr>
        </thead>

        <tbody>
            @php
                $products = $category->products()->with('store')->latest()->get();
            @endphp

            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name ?? 'N/A' }}</td>
                    <td class="badge {{ $category->status == 'active' ? 'bg-green' : 'bg-danger' }}">
                        {{ $category->status }}
                    </td>
                    <td>{{ $category->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">no products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

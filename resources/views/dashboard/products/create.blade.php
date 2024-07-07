@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='products' main_page='products' page='create' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-sm btn-outline-success">
            BackToproducts
        </a>
    </div>


    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('dashboard.products._form')
    </form>
@endsection

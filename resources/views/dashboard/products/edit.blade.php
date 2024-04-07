@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='products' main_page='products' page='edit' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-sm btn-outline-success">
            BackToProducts
        </a>
    </div>

    <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('dashboard.products._form', ['button_lable' => 'Update'])
    </form>
@endsection

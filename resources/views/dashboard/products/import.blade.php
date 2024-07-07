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

    <form action="{{ route('dashboard.products.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <x-form.input label="Products Count" class="form-control-lg" name="count" />
        </div>
        <button type="submit" class="btn btn-primary">Start Import...</button>
    </form>
@endsection

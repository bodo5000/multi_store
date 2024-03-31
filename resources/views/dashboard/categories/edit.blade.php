@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='categories' main_page='categories' page='edit' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-success">
            BackToCategories
        </a>
    </div>

    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('dashboard.categories._form', ['button_lable' => 'Update'])
    </form>
@endsection

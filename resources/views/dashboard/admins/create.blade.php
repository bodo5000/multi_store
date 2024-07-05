@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='categories' main_page='categories' page='create' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.admins.index') }}" class="btn btn-sm btn-outline-success">
            Back To Admins
        </a>
    </div>
    <form action="{{ route('dashboard.admins.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('dashboard.admins._form')
    </form>
@endsection

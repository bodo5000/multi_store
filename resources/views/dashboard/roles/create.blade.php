@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='roles' main_page='roles' page='create' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-sm btn-outline-success">
            Back To roles
        </a>
    </div>

    <form action="{{ route('dashboard.roles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.roles._form', ['button_lable' => 'Create'])

    </form>
@endsection

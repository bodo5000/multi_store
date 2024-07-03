@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='roles' main_page='roles' page='edit' />
@endsection


@section('contnet')
    <div class="mb-5">
        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-sm btn-outline-success">
            BackToroles
        </a>
    </div>

    <form action="{{ route('dashboard.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('dashboard.roles._form', ['button_lable' => 'Update'])
    </form>
@endsection

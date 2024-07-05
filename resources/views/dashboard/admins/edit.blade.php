@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='admins' main_page='admins' page='edit' />
@endsection


@section('contnet')
    <form action="{{ route('dashboard.admins.update', $admin->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.admins._form', [
            'button_label' => 'Update',
        ])
    </form>
@endsection

@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='roles' main_page='roles' page='home' />
@endsection


@section('contnet')
    <x-alert type="success" />
    <x-alert type="danger" />
    <x-alert type="info" />
    <x-alert type="warning" />

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-5">
        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-sm btn-outline-success">
            Create role
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>created_at</th>
                <th>actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($roles as $index => $role)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td><a href="{{ route('dashboard.roles.show', $role) }}">{{ $role->name }}</a></td>
                    <td>{{ $role->created_at }}</td>

                    <td class="d-flex">

                        <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                            class="btn btn-sm btn-outline-primary mr-2">
                            Edit
                        </a>


                        <form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            @can('roles.delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="8">there is no roles yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $roles->withQueryString()->links() }}
@endsection

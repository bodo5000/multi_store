@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='admins' main_page='admins' page='home' />
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
        @can('admins.create')
            <a href="{{ route('dashboard.admins.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        @endcan
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td><a href="{{ route('dashboard.admins.show', $admin->id) }}">{{ $admin->name }}</a></td>
                    <td>{{ $admin->email }}</td>
                    <td></td>
                    <td>{{ $admin->created_at }}</td>
                    <td>
                        @can('admins.update')
                            <a href="{{ route('dashboard.admins.edit', $admin->id) }}"
                                class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('admins.delete')
                            <form action="{{ route('dashboard.admins.destroy', $admin->id) }}" method="post">
                                @csrf
                                <!-- Form Method Spoofing -->
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No admins defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    {{ $admins->withQueryString()->links() }}
@endsection

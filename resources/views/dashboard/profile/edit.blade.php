@extends('layouts.dashboard.index')

@section('header_conent')
    <x-header main_title='profile' main_page='profile' page='edit' />
@endsection


@section('contnet')
    <x-alert type='success' />
    <div class="mb-3">
        <a href="{{ route('dashboard.dashboard') }}" class="btn btn-sm btn-outline-success">
            Home
        </a>
    </div>

    <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <x-form.input class="mb-2" type="text" name="first_name" :value="$user->profile->first_name ?? ''" label="first_name" />
        <x-form.input class="mb-2" type="text" name="last_name" :value="$user->profile->last_name ?? ''" label="last_name" />
        <x-form.input class="mb-2" type="date" name="birthday" :value="$user->profile->birthday ?? ''" label="birthday" />

        <div class="form-group mb-2">
            <label for="exampleRadios1">gender</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="male"
                    @checked(($user->profile->gender ?? old('gender')) == 'male')>
                <label class="form-check-label" for="exampleRadios1">
                    male
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="female"
                    @checked(($user->profile->gender ?? old('gender')) == 'female')>
                <label class="form-check-label" for="exampleRadios1">
                    female
                </label>
            </div>
            @error('gender')
                <p class="text_danger">{{ $message }}</p>
            @enderror
        </div>

        <x-form.input class="mb-2" type="text" name="street_address" :value="$user->profile->street_address ?? ''" label="street_address" />
        <x-form.input class="mb-2" type="text" name="city" :value="$user->profile->city ?? ''" label="city" />
        <x-form.input class="mb-2" type="text" name="state" :value="$user->profile->state ?? ''" label="state" />
        <x-form.input class="mb-2" type="text" name="postal_code" :value="$user->profile->postal_code ?? ''" label="postal_code" />
        <x-form.select class="mb-2" name="country" :options="$countries" label="Country" :selected="$user->profile->country ?? ''" />
        <x-form.select class="mb-2" name="locale" :options="$locales" label="Locale" :selected="$user->profile->locale ?? ''" />

        <button type="submit" class="btn btn-sm btn-success my-2">update</button>
    </form>
@endsection

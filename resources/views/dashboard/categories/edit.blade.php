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

    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="category_name">category name</label>
            <input id="category_name" type="text" name="name" class="form-control" value="{{ $category->name }}">
        </div>

        <div class="form-group">
            <label for="category_parent">category parent</label>
            <select class="form-control" name="parent_id" id="category_parent">
                <option value="">primary category</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_description">category description</label>
            <textarea id="category_description" name="description" class="form-control">{{ $category->description ?? '' }}</textarea>
        </div>


        <div class="form-group">
            <label for="category_image">category image</label>
            <input id="category_image" type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="">status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="active"
                    @checked($category->status == 'active')>
                <label class="form-check-label" for="exampleRadios1">
                    active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="archived"
                    @checked($category->status == 'arcived')>
                <label class="form-check-label" for="exampleRadios2">
                    archived
                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </div>
    </form>
@endsection

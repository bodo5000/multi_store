@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-form.input type="text" name="name" :value="$category->name" label="category name" />

<div class="form-group">
    <label for="category_parent">category parent</label>
    <select class="form-control" name="parent_id" id="category_parent">
        <option value="">primary category</option>
        @error('parent_id')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        @foreach ($parents as $parent)
            <option value="{{ $parent->id ?? '' }}" @selected(($category->parent_id ?? old('parent_id')) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="category_description">category description</label>
    <textarea id="category_description" name="description" class="form-control">{{ $category->description ?? old('description') }}</textarea>
    @error('description')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>


<div class="form-group">
    <label for="category_image">category image</label>
    <input id="category_image" type="file" name="image" class="form-control">

    @error('image')
        <p class="text_danger">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="">status</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="active"
            @checked(($category->status ?? old('status')) == 'active')>
        <label class="form-check-label" for="exampleRadios1">
            active
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="archived"
            @checked(($category->status ?? old('status')) == 'archived')>
        <label class="form-check-label" for="exampleRadios2">
            archived
        </label>
    </div>

    @error('status')
        <p class="text_danger">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-outline-primary">{{ $button_lable ?? 'Save' }}</button>
</div>

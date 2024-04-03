@props(['type', 'name', 'value', 'label'])
<div class="form-group">
    <label for="category_name">{{ $label }}</label>
    <input id="category_name" type="{{ $type }}" name="{{ $name }}"
        class="form-control @error('name') is-invalid @enderror" value="{{ $value ?? old('name') }}">
    @error('name')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

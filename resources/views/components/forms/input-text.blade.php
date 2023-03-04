<div class="w-full form-control">
    <label class="label" for="input-{{ $name }}">
        <span class="label-text">{{ $label }}</span>
    </label>
    <input type="text" id="input-{{ $name }}" name="{{ $name }}" @if ($placeholder) placeholder="{{ $placeholder }}" @endif @if ($value) value="{{ $value }}" @endif class="w-full input input-bordered bg-neutral text-neutral-content border-primary" />
</div>

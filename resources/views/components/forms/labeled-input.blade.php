<div class="w-full form-control">
    <label class="w-full input-group input-group-md" for="input-{{ $name }}">
        <span class="w-3/12 font-bold rounded-l-lg bg-primary text-primary-content">{{ $label }}</span>
        <input type="text" id="input-{{ $name }}" name="{{ $name }}" @if ($placeholder) placeholder="{{ $placeholder }}" @endif @if ($value) value="{{ $value }}" @endif class="w-8/12 input input-bordered bg-neutral border-primary" />
    </label>
</div>

<div class="form-control">
    <label for="select-{{ $name }}" class="label">
        <span class="label-text">{{ $label }}</span>
    </label>
    <select class="w-full max-w-xs select select-primary bg-neutral" name="{{ $name }}" id="select-{{ $name }}">
        @if ($first) <option disabled @if (!$selected) selected @endif>{{ $first }}</option> @endif
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}" @if ($selected == $option['value']) SELECTED @endif>{{ $option['text'] }}</option>
        @endforeach
    </select>
</div>
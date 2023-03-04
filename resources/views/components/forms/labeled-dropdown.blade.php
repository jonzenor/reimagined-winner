<div class="form-control">
    <label class="w-full input-group input-group-md" for="input-{{ $name }}">
        <span class="w-3/12 font-bold rounded-l-lg bg-primary text-primary-content">{{ $label }}</span>
        
        <select class="w-8/12 max-w-xs select select-primary bg-neutral" name="{{ $name }}" id="select-{{ $name }}">
            @if (isset($first)) <option disabled @if (!$selected) selected @endif>{{ $first }}</option> @endif
            @foreach ($options as $option)
                <option value="{{ $option['value'] }}" @if (isset($selected) && $selected == $option['value']) SELECTED @endif>{{ $option['text'] }}</option>
            @endforeach
        </select>
    </label>
</div>
<label for="{{ $id ?? '' }}">{{ $title ?? '' }}</label>
<select name="{{ $name ?? '' }}"
        id="{{ $id ?? '' }}"
        class="form-control form-control-sm"
        @isset($required) required @endisset
        @isset($readonly) readonly @endisset
>
    @forelse($options as $index => $item)
        <option
                @if(isset($value) && $value == $index) selected @endif
        value="{{ isset($optionValue) && isset($item[$optionValue]) ? $item[$optionValue] : $index }}">{{ isset($optionText) && isset($item[$optionText]) ? $item[$optionText] : $item }}</option>
    @empty
    @endforelse
</select>
<label for="{{ $id ?? '' }}">{{ $title ?? '' }}</label>
<textarea class="form-control form-control-sm {{ $class ?? '' }}"
          id="{{ $id ?? '' }}"
          name="{{ $name ?? '' }}"
          style="{{ $style ?? '' }}"
          @isset($required) required @endisset
          @isset($readonly) readonly @endisset
          @isset($disabled) disabled @endisset
>{{ $value ?? '' }}</textarea>
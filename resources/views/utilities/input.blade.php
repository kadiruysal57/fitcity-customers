<label for="{{ $id ?? '' }}">{{ $title ?? '' }}</label>
<input type="{{ $type ?? 'text' }}"
       name="{{ $name ?? '' }}"
       value="{{ $value ?? '' }}"
       id="{{ $id ?? '' }}"
       class="form-control form-control-sm {{ $class ?? '' }}"
       @isset($required) required @endisset
       @isset($readonly) readonly @endisset
       @isset($disabled) disabled @endisset
       @isset($min) min="{{ $min }}" @endisset
       @isset($max) max="{{ $max }}" @endisset
       @isset($minlength) minlength="{{ $minlength }}" @endisset
       @isset($maxlength) maxlength="{{ $maxlength }}" @endisset
       placeholder="{{ isset($placeholder) ? $placeholder : (isset($title) ? $title : '') }}"
/>
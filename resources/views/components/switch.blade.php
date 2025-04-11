@props(['value' => "0"])

<label class="switch">
    <input name="check" type="checkbox" value="{{ $value }}" @checked($value) />
</label>
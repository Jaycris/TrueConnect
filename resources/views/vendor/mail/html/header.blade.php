@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/bma-vertical-logo.png') }}" alt="Bookmarc Alliance" style="max-height: 75px;">@else
{{ $slot }}
@endif
</a>
</td>
</tr>

@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/page-chronicles-logo.png') }}" alt="Page Chronicles" style="max-height: 130px;">@else
{{ $slot }}
@endif
</a>
</td>
</tr>

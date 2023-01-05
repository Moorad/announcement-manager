@props(['disabled' => false, 'other' => ''])

<button {{ $disabled ? 'disabled' : '' }} {!! $other !!}
    class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg hover:bg-blue-400'>{{ $text }}</button>

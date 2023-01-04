@isset($variant)
    @if ($variant == 'info')
        <div
            class="bg-indigo-100 px-8 py-5 rounded-md border border-indigo-200 text-center w-full mx-auto text-indigo-600 max-w-[40rem] mt-4">
            {!! $content !!}
        </div>
    @elseif ($variant == 'warning')
        <div
            class="bg-amber-50 px-8 py-5 rounded-md border border-amber-100 text-center w-full mx-auto text-amber-600 max-w-[40rem] mt-4">
            {!! $content !!}
        </div>
    @else
        <div
            class="bg-gray-100 px-8 py-5 rounded-md border border-gray-200 text-center w-full mx-auto text-gray-600 max-w-[40rem] mt-4">
            {!! $content !!}
        </div>
    @endif
@else
    <div
        class="bg-gray-100 px-8 py-5 rounded-md border border-gray-200 text-center w-full mx-auto text-gray-600 max-w-[40rem] mt-4">
        {!! $content !!}
    </div>
@endisset

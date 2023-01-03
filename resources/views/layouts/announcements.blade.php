<div class='flex flex-col justify-center items-center gap-10 mt-6'>
    @if (($in_org != null || $owns_org != null) && count($announcements) == 0)
        <div class='text-gray-400'>{{ $empty_message }}</div>
    @endif

    @foreach ($announcements as $announcement)
        @include('layouts.announcement')
    @endforeach

    {{ $announcements->links() }}
</div>

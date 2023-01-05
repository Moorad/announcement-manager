@extends('layouts.main')

@section('content')
    <div>
        <form method="POST" action="{{ route('organisations.store') }}" class="flex flex-col gap-10">
            @csrf

            @method('POST')

            <div>
                <x-input-label for="org_name" :value="__('Organisation name')" />
                <x-text-input id="org_name" class="block mt-1 w-full" type="text" name="org_name" required autofocus />
            </div>

            <div class="self-end">
                @include('components.button', [
                    'text' => 'Sumbit',
                ])
            </div>
        </form>
    </div>
@endsection

@extends('layouts.main')

@section('content')
    @if ($errors->any())
        @include('components.alert', [
            'content' => $errors->first(),
            'variant' => 'error',
        ])
    @endif
    <form method="POST" action="{{ route('announcements.store') }}" class="flex flex-col gap-10" enctype="multipart/form-data">
        @csrf

        @method('POST')

        <div class='flex flex-col gap-5'>
            <div>
                <x-input-label for="announcement_title" :value="__('Announcement Title')" />
                <x-text-input id="announcement_title" class="block mt-1 w-full" type="text" name="announcement_title"
                    required autofocus />
            </div>
            <div>
                <x-input-label for="announcement_text" :value="__('Announcement Text')" />
                <textarea id="announcement_text"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-40"
                    type="text" name="announcement_text" required autofocus></textarea>
            </div>

            <div class="flex justify-between">
                <div>
                    <x-input-label for="announcement_image" :value="__('Attach Images (Optional)')" />
                    <input name="announcement_image" type="file" id='announcement_image' accept="image/*"
                        class='mt-1 text-grey-500
						file:mr-5 file:py-2 file:px-4
						file:rounded-md file:border-0
						file:text-base file:font-medium
						file:bg-blue-500 file:text-white
						hover:file:cursor-pointer hover:file:bg-blue-400' />
                    <div class='text-gray-500'>SVG, PNG, JPG, GIF or WebP.</div>
                </div>

                <div>
                    <input type="text" value="" name="giphy_gif_src" id='giphy_gif_src' class="hidden">
                    <x-input-label for="giphy_image" :value="__('Or use Giphy')" />
                    <div class="flex items-center gap 5">
                        <div class="flex gap-2 bg-black w-fit h-fit text-white px-4 py-2 rounded-md cursor-pointer hover:bg-gray-900"
                            onclick="toggleGiphySection()">
                            <img src="https://cdn.worldvectorlogo.com/logos/giphy-logo-1.svg" alt="" class="h-5">
                            <div>Giphy</div>
                        </div>
                        <div class="ml-5 mr-3" id='selected_gif_text'>No gif selected</div>
                    </div>
                    <div class="text-gray-500">If an image is attached the gif will be ignored</div>
                </div>
            </div>

            <div id="giphy-section" class="hidden">
                <x-input-label for="gif_search" :value="__('Search for a gif')" />
                <div class="flex items-center">
                    <x-text-input id="gif_search" class="block w-full" type="text" />
                    <button class='bg-blue-500 text-white px-4 rounded-md mx-2 h-10'
                        onclick="event.preventDefault();giphyLoadSearch()">Search</button>
                </div>
                <div id='gif-list' class="text-gray-500 text-center my-4">
                    @include('components.gif-list')
                </div>
            </div>
            <div>
                <x-input-label for="announcement_tags[]" :value="__('Announcement Tags')" />
                <fieldset>
                    <div class="grid grid-cols-6 gap-2 mt-3">
                        @foreach ($tags as $tag)
                            <div>
                                <input type="checkbox" name="announcement_tags[]" value="{{ $tag->id }}">
                                <label for="announcement_tags[]">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
            <div>
                <x-input-label for="announcement_priority" :value="__('Announcement Priority')" />

                <input type="radio" id="high" name="announcement_priority" value="high">
                <label for="high">High</label>
                <div class="text-sm text-gray-400">
                    An email notification will be sent to all members and the announcement will be
                    pinned.
                </div>
                <input type="radio" id="normal" name="announcement_priority" value="normal">
                <label for="normal">Normal</label>
                <div class="text-sm text-gray-400">
                    An email notification will be sent to all members.
                </div>
                <input type="radio" id="low" name="announcement_priority" value="low" checked>
                <label for="low">Low</label>
                <div class="text-sm text-gray-400">
                    No email notification will be sent.
                </div>
            </div>
        </div>

        <div class="self-end">
            @include('components.button', [
                'text' => 'Submit',
            ])
        </div>
    </form>

    <script>
        let sectionOpen = false;

        function toggleGiphySection() {
            const giphySection = document.querySelector('#giphy-section');
            if (sectionOpen) {
                giphySection.classList.add('hidden');
            } else {
                giphyLoadTrending();
                giphySection.classList.remove('hidden');
            }
            sectionOpen = !sectionOpen;
        }

        function giphyLoadTrending() {
            fetch("<?php echo route('giphy.trending'); ?>")
                .then((res) => res.text())
                .then((res) => {
                    document.querySelector('#gif-list').innerHTML = res;
                });
        }

        function giphyLoadSearch() {
            const q = document.querySelector('#gif_search').value;
            fetch("<?php echo route('giphy.search'); ?>?q=" + q)
                .then((res) => res.text())
                .then((res) => {
                    document.querySelector('#gif-list').innerHTML = res;
                });
        }

        function selectGif(img) {
            toggleGiphySection();
            document.querySelector('#giphy_gif_src').value = img.src;
            document.querySelector('#selected_gif_text').innerText = img.dataset.id

        }
    </script>
@endsection

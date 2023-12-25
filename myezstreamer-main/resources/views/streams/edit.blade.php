@php
use App\Models\Stream;
$stream_count = Stream::count();
@endphp
<x-app-layout>
        <!-- Errors -->
        @if($errors->any())
        <p class="text-red-500 text-md mt-1">Validation Errors for most recent save:</p>
        @error('stream_name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('input_url')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('youtube_url')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('youtube_backup_url')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('standby_stream_img')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('youtube_key')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('send_audio')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <!-- End Errors-->
        @endif

        <!-- Edit each stream -->
        <div class="mt-8">
            <div class="shadow-xl rounded-lg bg-indigo-50 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @if($streams->count() >= 1)
                @foreach($streams as $stream)
                    <x-streams-editor :stream="$stream" :loop="++$loop->index"/>
                    <x-jet-section-border />
                @endforeach
                @else
                    <p class="text-center">It looks like you don't have any streams configured yet! 
                    <br>Click the button below to configure your first stream.</p>
                @endif
            </div>
        </div>

       

        <!-- Create a new stream -->
        @if($stream_count <= 3)
        <div class="p-12 text-center sm:p-8">
        <form action="/streams/new" method="GET">
            @csrf
            <button type="submit" class="border border-slate-300 rounded-lg px-3 py-2 bg-indigo-50 hover:bg-indigo-200 font-semibold">Configure a new stream.</button>
        </form>
        </div>      
        @endif
</x-app-layout>

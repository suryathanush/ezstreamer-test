<div class="w-full">
    <div class="py-2 sm:py-4 md:py-6 bg-white shadow rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 px-6 xl:px-10 gap-y-8 gap-x-12 2xl:gap-x-28">
            <div class="w-full">
                <p tabindex="0" class="focus:outline-none text-xs md:text-sm font-medium leading-none text-gray-500 uppercase">{{ $stream->stream_name ?? "Stream ". ++$loop->index }}</p>
                <div class="flex items-center justify-center p-3">
                  <livewire:poll-screenshot :stream_id="$stream->id" :input_url="$stream->input_url" />
                </div>
                
            </div>
            <div class="w-full">
                <p tabindex="0" class="focus:outline-none text-xs md:text-sm font-medium leading-none text-gray-500 uppercase">fps</p>
                <p tabindex="0" class="focus:outline-none text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold leading-3 text-gray-800 mt-3 md:mt-5">
                @php
                $statsToGet = '-f';
                @endphp
                    <livewire:poll-stream  :stream_id="$stream->id" :statsToGet="$statsToGet" />
                </p>
            </div>
            <div class="w-full">
                <p tabindex="0" class="focus:outline-none text-xs md:text-sm font-medium leading-none text-gray-500 uppercase">bitrate</p>
                <p tabindex="0" class="focus:outline-none text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold leading-3 text-gray-800 mt-3 md:mt-5">
                @php
                $statsToGet = '-b';
                @endphp
                    <livewire:poll-stream  :stream_id="$stream->id" :statsToGet="$statsToGet" />
                </p>
            </div>
        </div>
    </div>
</div>

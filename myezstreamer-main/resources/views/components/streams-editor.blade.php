<div class="pb-8 pt-6">
  <div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">
            <!--Use stream_name if set, or Stream index otherwise-->
            @if(is_null($stream->stream_name) || $stream->stream_name == '')
              Stream {{ $loop }}
            @else
              {{ $stream->stream_name }}<br><small>Stream {{ $loop }}</small>
            @endif
          
          </h3>
          <p class="mt-1 text-sm text-gray-600">Configure the settings for stream {{ $loop }}.</p>
          
          <!--Show standby stream image if it is set-->
          @if(!is_null($stream->standby_stream_img))
            <div class="pt-6">
              <label for="standby_stream_img" class="flex flex-row items-center justify-center content-center">Standby Image</label>
              <div id="standby_stream_img" class="flex items-center justify-center p-6">
                <img class="max-w-full max-h-fit" src="/storage/{{ $stream->standby_stream_img }}"/>
              </div>
              <div class="flex justify-center">
                <a class="pt-3 hover:text-red-700" href="{{ route('remove_image', $stream->id) }}">(Remove Standby Image)</a>
              </div>
            </div>
          @endif

          <livewire:poll-screenshot :stream_id="$stream->id" :input_url="$stream->input_url" />

          </div>
        </div>
      <div class="shadow-lg mt-5 md:mt-0 md:col-span-2">
        <form action="/streams/update/{{ $stream->id }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <input type="hidden" name="id" id="id" value="{{ $stream->id }}">
                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                  <label for="stream_name" class="block text-sm font-medium text-gray-700">Stream Name</label>
                  <input value="{{ $stream->stream_name }}" type="text" name="stream_name" id="stream_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>   
                <div class="col-span-6 md:col-span-3 lg:col-span-4">
                  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                  <input value="{{ $stream->description }}" type="text" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-3">
                  <label for="youtube_key" class="block text-sm font-medium text-gray-700">YouTube Key</label>
                  <input value="{{ $stream->youtube_key }}" type="text" name="youtube_key" id="youtube_key" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">            
                </div>
                <div class="col-span-6">
                  <label for="input_url" class="block text-sm font-medium text-gray-700">Input URL</label>
                  <input value="{{ $stream->input_url }}" type="text" name="input_url" id="input_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6">
                  <label for="youtube_url" class="block text-sm font-medium text-gray-700">YouTube URL</label>
                  <input value="{{ $stream->youtube_url }}" type="text" name="youtube_url" id="youtube_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6">
                  <label for="youtube_backup_url" class="block text-sm font-medium text-gray-700">YouTube Backup URL</label>
                  <input value="{{ $stream->youtube_backup_url }}" type="text" name="youtube_backup_url" id="youtube_backup_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6">
                  <label for="standby_stream_img" class="block text-sm font-medium text-gray-700">Standby Stream Image</label>
                  <input value="{{ $stream->standby_stream_img }}" type="file" name="standby_stream_img" id="standby_stream_img" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <!-- Send Audio -->
                <div class="col-span-6 pt-6 form-check">
                  <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="1" id="send_audio" name="send_audio"
                  @if($stream->send_audio == "1")
                    checked
                  @endif
                  >
                  <label class="form-check-label inline-block text-gray-800" for="send_audio">
                  Enable Audio
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-4 bg-indigo-100">
            <div class="col-span-2 2xl:col-span-1"> 
              <div class="px-4 py-3 2xl:py-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save Changes</button>
              </div>
            </div>
        </form>
            <div class="col-span-2 2xl:col-span-1"> 
              <div class="px-4 py-3 2xl:py-6">
                <form action="/streams/delete/{{ $stream->id }}" method="POST">
                  @csrf
                  <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete</button>
                </form>
              </div>
            </div>
            <div class="col-span-2 2xl:col-span-1"> 
              <div class="px-4 py-3 2xl:py-6">
                <form action="/streams/restart" method="POST">
                  @csrf
                  <input type="hidden" id="stream_service" name="stream_service" value="{{ $stream->stream_service }}">
                  <input type="hidden" id="stream_name" name="stream_name" value="{{ $stream->stream_name }}">
                  <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md whitespace-nowrap text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Start Stream</button>
                </form>
              </div>
            </div>
            <div class="col-span-2 2xl:col-span-1"> 
              <div class="px-4 py-3 2xl:py-6">
                <form action="/streams/standbytest" method="POST">
                  @csrf
                  <input type="hidden" id="stream_service" name="stream_service" value="{{ $stream->stream_service }}">
                  <input type="hidden" id="standby_service" name="standby_service" value="{{ $stream->standby_service }}">
                  <input type="hidden" id="stream_name" name="stream_name" value="{{ $stream->stream_name }}">
                  <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md whitespace-nowrap text-gray-700 bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">Test Standby Stream</button>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

@php
$numStreams = App\Models\Stream::count();
@endphp
<x-app-layout>
  <div>
    @if($numStreams > 0)
      <div class="container mx-auto grid sm:grid-cols-2 pt-6 gap-4">
      @foreach($streams as $stream)
        <div class="flex rounded">
          <x-stream-stats :stream="$stream" :loop="$loop"/>
        </div>
      @endforeach
      </div>
    @else
      <div class="flex items-center justify-center h-96">
        <form action="/streams/new" method="GET">
          @csrf
          <button type="submit" class="border border-slate-300 rounded-lg px-3 py-2 bg-indigo-50 hover:bg-indigo-200 font-semibold">Configure a new stream.</button>
        </form>
      </div>
    @endif
  </div>
</x-app-layout>

@if (session()->has('success'))
<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 4000)"
     x-show="show"
     class="text-center bg-indigo-500 text-white py-2 px-4 rounded-xl text-lg"
>
    <p>{{ session('success') }}</p>
</div>
@elseif (session()->has('failed'))
<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 10000)"
     x-show="show"
     class="text-center bg-red-500 text-black py-2 px-4 rounded-xl text-lg"
>
    <p>{{ session('failed') }}</p>
</div>
@endif

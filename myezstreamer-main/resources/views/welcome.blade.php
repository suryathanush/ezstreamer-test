<x-guest-layout>
  <body class="bg-slate-600">
    <div class="h-screen flex items-center justify-center content-center max-w-xl mx-auto">
        <div class="flex flex-col lg:flex-row w-full items-start lg:items-center drop-shadow-2xl">
            <div class="flex flex-col items-center content-center justify-center w-full lg:w-7/12 h-64 bg-slate-50 rounded-l">
              <!-- Links -->
              @auth 
                <div class="p-3"><a class="text-2xl" href="/overview">Overview</a></div>
                <div class="p-3"><a class="text-2xl" href="/streams">Streams</a></div>
                <!--<div class="p-3"><a href="/monitor">Monitor</a></div>-->
                <div class="p-3">
                  <form method="POST" action="{{ route('logout') }}" x-data>
                      @csrf
                      <a class="text-2xl" href="{{ route('logout') }}" @click.prevent="$root.submit();">
                          {{ __('Log Out') }}
                      </a>
                  </form>

                </div>
              @else 
                <div class="p-6 "><a class="text-2xl" href="/login">Login</a></div>
              @endauth
            </div>
            <div class="flex content-center justify-center w-full lg:w-5/12 h-24 lg:h-64 border-t lg:border-t-0 lg:border-r lg:border-l lg:rounded-r bg-indigo-50">
            <!-- Logo -->
              <a href="{{ route('login') }}" class="flex items-center justify-center content-center">
            
               <img src="{{url('logo/logo.png')}}" alt="" style="width=99.000000pt; height=70.000000pt; padding:30px;">
              <g transform="translate(0.000000,70.000000) scale(0.100000,-0.100000)"
              fill="#000000" stroke="none">
                <defs>
                  <style>
                    svg {
                      background-color: transparent;
                      color-scheme:light dark;
              	  fill: black;
                    }
                    @media (prefers-color-scheme:dark) {
                      svg {
                        background-color: transparent;
              	  fill: rgb(238 242 255);
                      }
                    }
                  </style>
                </defs>
              <path d="M40 345 l0 -305 200 0 200 0 0 45 0 45 -150 0 -150 0 -1 83 c0 45 -2
              90 -4 100 -3 16 9 17 151 17 l154 0 0 45 0 45 -152 0 -153 0 0 70 0 70 153 0
              152 0 0 45 0 45 -200 0 -200 0 0 -305z"/>
              <path d="M479 638 c-1 -7 -2 -26 -3 -43 l-1 -30 172 -5 172 -5 -100 -125 c-55
              -69 -113 -140 -127 -159 -15 -18 -37 -44 -50 -58 -45 -49 -70 -97 -68 -133 l1
              -35 238 -3 237 -2 0 45 0 45 -175 0 c-96 0 -175 3 -175 6 0 5 125 162 220 275
              30 36 70 84 87 105 38 45 48 73 39 109 l-6 25 -230 0 c-177 0 -230 -3 -231
              -12z"/>
              </g>
              </svg>
              </a>

            </div>
        </div>
    </div>
  </body>
</x-guest-layout>

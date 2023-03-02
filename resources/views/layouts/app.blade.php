<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/94e4b1fd9f.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-base antialiased bg-base-100">
        
        <div class="w-11/12 m-auto my-4 rounded-lg navbar bg-neutral text-neutral-content">
            {{-- Mobile nav drop down menu and left logo items --}}
            <div class="navbar-start">
              <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                </label>
                <ul tabindex="0" class="p-2 mt-3 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                  <li><a>Item 1</a></li>
                  <li tabindex="0">
                    <a class="justify-between">
                      Parent
                      <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"/></svg>
                    </a>
                    <ul class="p-2">
                      <li><a>Submenu 1</a></li>
                      <li><a>Submenu 2</a></li>
                    </ul>
                  </li>
                  <li><a>Item 3</a></li>
                </ul>
              </div>

              {{-- Left hand logo items --}}
              <a class="text-xl normal-case btn btn-ghost" href="{{ route('home') }}"><img src="{{ asset('storage/images/Logo-Dark-Red-zenor-225x90.png') }}" width="125px" alt="JonZenor.com" class="drop-shadow-xl"></a>
            </div>

            {{-- Normal desktop nav menu --}}
            <div class="hidden navbar-center lg:flex">
              <ul class="px-1 menu menu-horizontal bg-neutral">
                <li><a>Item 1</a></li>
                <li tabindex="0">
                  <a>
                    Parent
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/></svg>
                  </a>
                  <ul class="p-2">
                    <li class="rounded-md bg-base-300 text-base-content hover:text-neutral-content hover:bg-neutral"><a>Submenu 1</a></li>
                    <li class="rounded-md bg-base-300 text-base-content hover:text-neutral-content hover:bg-neutral"><a>Submenu 2</a></li>
                  </ul>
                </li>
                <li><a>Item 3</a></li>
              </ul>
            </div>

            {{-- Right hand nav elements for all sizes--}}
            <div class="navbar-end">
              @guest
                <a class="btn" href="{{ route('login') }}">LOGIN</a>
              @endguest

              @auth
                
              @endauth
             
            </div>
          </div>




        <div class="min-h-screen bg-base-100">

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        

        <style>
            #new_tweet{
                background-color: #6775f5; 
                border-radius: 50%; 
                width: 5rem; 
                height: 5rem; 
                position: fixed; 
                bottom: 2rem; 
                right: 2rem; 
                color: white; 
                font-size: large; 
                font-weight: bold;
                transition: transform 0.2s;
            }

            #new_tweet:hover{
                transform: scale(1.2, 1.2);
                box-shadow: 0 0 8px gray;
                opacity: 0.8;
            }

            




        </style>
        <!-- Font Awesome -->
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <!-- New Tweet button -->
            <div>
                <button type="button" id="new_tweet">
                    <a href="{{ route('tweets.create', auth()->user()->id) }}">＋</a>
                </button>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>

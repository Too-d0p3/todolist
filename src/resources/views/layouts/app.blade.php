<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <title>To-Do</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="bg-primary-light text-white text-sm">
        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                class="fixed bottom-0 right-0 mb-4 mr-4 p-3 bg-green-600 text-white rounded transition-opacity duration-500 flex items-center gap-4 font-medium"
            >
                <i class="fa-solid fa-circle-check text-green-200 text-lg "></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                class="fixed bottom-0 right-0 mb-4 mr-4 p-3 bg-red-500 text-white rounded transition-opacity duration-500 flex items-center gap-4 font-medium"
            >
                <i class="fa-solid fa-circle-exclamation text-red-300 text-lg"></i> {{ session('error') }}
            </div>
        @endif


        <div class="container 2xl:w-[33%] xl:w-[40%] lg:w-[50%%] md:w-[55%] sm:w-[70%] w-[90%] m-auto h-[100dvh] max-h-[100dvh] py-10">
            <div class="bg-primary p-4 max-h-full @yield('containerHeight', 'h-full')">
                @yield('content')
                @vite('resources/js/app.js')
            </div>
            @livewireScripts
        </div>
    </body>
</html>

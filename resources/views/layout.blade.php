<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Flamento | Magic DB') }}</title>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- Inlcude css from package -->
    <!-- <link rel="stylesheet" href="{{ asset('vendor/magicdb/css/magicdb.css') }}"> -->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        span[aria-current="page"] span {
            background-color: #4f46e5;
            color: #fff;
        }
    </style>


</head>

<body class="font-sans antialiased bg-gray-50">

    <aside
        class="bg-gray-50 h-screen w-screen hidden fixed overflow-y-auto z-30 md:max-w-md md:border-r-8 md:border-r-indigo-400 md:shadow-lg"
        id="table-sidebar">
        <div class="p-2 flex justify-between items-center">
            <h4 class="text-lg font-bold text-gray-700">Tables</h4>
            <button class="flex table-sidebar-toggle"><i class="uil uil-multiply text-[18px]"></i></button>
        </div>
        <ul>
            @foreach ($tables as $table)
                <li class="p-2 border-t">
                    <a href="{{ route('magicdb.showTable', $table) }}" class="text-sm flex items-center gap-2">
                        <i class="uil uil-table text-[18px]"></i>
                        {{ $table }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <nav class="">
        <div class="flex justify-between items-center bg-indigo-500 border-b-8 border-b-indigo-600 text-white p-2">
            <div class="flex items-center gap-2">
                <button class="flex table-sidebar-toggle"><i class="uil uil-bars text-[18px]"></i></button>
                <h4 class="text-lg font-bold text-white">
                    <a href="{{ route('magicdb.index') }}">Magic DB</a>
                </h4>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('magicdb.mysqlBackup') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex"><i class="uil uil-cloud-download text-[18px]"></i></button>
                </form>
                <a href="{{ route('magicdb.logout') }}" class="flex"><i class="uil uil-power text-[18px]"></i></a>
            </div>
        </div>
    </nav>


    @error('error')
        <div class="text-sm m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @enderror


    @yield('content')


    <script defer>
        document.querySelectorAll('.table-sidebar-toggle')
            .forEach((el) => {
                el.addEventListener('click', () => {
                    document.querySelector('#table-sidebar').classList.toggle('hidden')
                })
            })
    </script>
</body>

</html>

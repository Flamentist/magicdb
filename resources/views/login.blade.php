<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Flamento | Magic DB') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex items-center justify-center h-[90vh]">
        <div class="bg-white shadow-md p-4 w-full max-w-sm">
            <form action="{{ route('magicdb.login') }}" method="POST" class="flex flex-col gap-2">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="username" class="font-semibold ">Username</label>
                    <input required type="text" name="username" placeholder="Enter here" id="username"
                        class="w-full p-2 text-sm rounded outline-none bg-indigo-100 border-b-8 border-indigo-500"
                        value="{{ old('username') }}">
                    @error('username')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>
                <div class="flex flex-col gap-1">
                    <label for="password" class="font-semibold ">Password</label>
                    <input required type="password" name="password" placeholder="Enter here" id="username"
                        class="w-full p-2 text-sm rounded outline-none bg-indigo-100 border-b-8 border-indigo-500">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-indigo-500 mt-4 text-white px-4 py-2 border-b-8 rounded shadow-md text-sm w-fit border-b-indigo-600 font-semibold relative hover:translate-y-1 duration-100 transition-transform">Login</button>
            </form>
        </div>
    </div>

    <span
        class="fixed bottom-2 right-2 bg-indigo-400 opacity-40 py-1 pointer-events-none px-2 text-xs rounded text-white">Powered
        by
        <strong>Magic
            DB</strong></span>
</body>

</html>

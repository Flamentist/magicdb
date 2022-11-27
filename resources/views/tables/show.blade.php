{{-- content --}}
@extends('magicdb::layout')

@section('content')
    <div class="flex flex-col gap-2 py-5 px-4">

        <div class="bg-indigo-200 p-2 py-1 border-l-8  border-l-indigo-600 flex flex-col gap-1">
            <i class="uil uil-table text-[24px]"></i>
            <h4 class="font-bold text-gray-700">Table: {{ $tableName }}</h4>
        </div>
        <div class="grid grid-cols-1 gap-2 ">
            <div class="bg-white shadow p-2 flex flex-col items-center justify-center gap-1 overflow-x-auto">
                <span class="text-3xl font-bold">{{ $totalRows }}</span>
                <div class="flex items-center gap-1 font-semibold"><i class="uil uil-database-alt text-[24px]"></i> Records
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border text-xs border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border text-xs border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white border">
            <form action="" method="GET">
                <textarea autofocus class="w-full p-2 outline-none text-sm"
                    placeholder="Enter Query (Supports Select, Update, Delete, etc.)" name="query">{{ request('query') }}</textarea>
                <div class="flex justify-end p-2 bg-gray-100">
                    <button type="submit"
                        class="bg-indigo-500 text-white px-4 py-2 border-b-8 rounded shadow-md text-sm w-fit border-b-indigo-600 font-semibold relative hover:translate-y-1 duration-100 transition-transform">Execute</button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow p-2 overflow-auto max-h-96">
            <table class="table-auto w-full text-sm">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th class="px-2 py-1 text-sm whitespace-pre">{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr class="border-t border-t-indigo-200 ">
                            @foreach ($record as $key => $value)
                                <td class="px-2 py-1 text-sm whitespace-pre">{{ $value === null ? '(NULL)' : $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (!request()->has('query'))
            {{ $records }}
        @endif
    @endsection

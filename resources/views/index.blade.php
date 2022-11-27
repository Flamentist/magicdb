{{-- content --}}
@extends('magicdb::layout')

@section('content')
    <!-- Welcome to index -->

    <!-- TODOS: -->
    {{-- 1. List all tables in left side
2. List all rows/columns of selected table in center
3. Add, Edit, Delete in each row
4. Add A Backup Button
5. Add A Backup Download Button
6. Store the backup in server --}}

    <div class="flex flex-col gap-2 py-5 px-4">
        <div class="grid grid-cols-2 gap-2 ">
            <div class="bg-white shadow p-2 flex flex-col items-center justify-center gap-1">
                <span class="text-3xl font-bold">{{ count($tables) }}</span>
                <div class="flex items-center gap-1 font-semibold"><i class="uil uil-table text-[24px]"></i> Tables</div>
            </div>
            <div class="bg-white shadow p-2 flex flex-col items-center justify-center gap-1 overflow-x-auto">
                <span class="text-3xl font-bold">{{ $totalRows }}</span>
                <div class="flex items-center gap-1 font-semibold"><i class="uil uil-database-alt text-[24px]"></i> Records
                </div>
            </div>
        </div>
    </div>
@endsection

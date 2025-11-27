{{-- resources/views/tasks/index.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 p-2 mb-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold">Task Manager</h1>
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Nueva tarea
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $columns = ['TODO' => 'Por hacer', 'DOING' => 'En curso', 'DONE' => 'Hecho'];
                @endphp

                @foreach($columns as $statusKey => $statusLabel)
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded">
                        <h2 class="font-semibold mb-2 text-gray-700 dark:text-gray-300">{{ $statusLabel }}</h2>

                        @foreach($tasks->where('status', $statusKey) as $task)
                            @include('tasks._card', ['task' => $task])
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

<div class="bg-white dark:bg-gray-700 p-3 mb-3 shadow rounded border dark:border-gray-600">
    <div class="flex justify-between">
        <div>
            <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $task->title }}</h3>
            @if($task->description)
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $task->description }}</p>
            @endif

            @if($task->start_date || $task->end_date)
                <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                    @if($task->start_date)
                        Inicio: {{ $task->start_date->format('d/m/Y') }}
                    @endif
                    @if($task->end_date)
                        · Fin: {{ $task->end_date->format('d/m/Y') }}
                    @endif
                </p>
            @endif

            @if($task->estimated_hours || $task->actual_hours)
                <p class="text-xs text-gray-600 dark:text-gray-300">
                    @if($task->estimated_hours)
                        Previstas: {{ $task->estimated_hours }}h
                    @endif
                    @if($task->actual_hours)
                        · Reales: {{ $task->actual_hours }}h
                    @endif
                </p>
            @endif

            @if($task->users->count())
                <p class="text-xs mt-1 text-gray-800 dark:text-gray-200">
                    Asignados:
                    {{ $task->users->pluck('name')->join(', ') }}
                </p>
            @else
                <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">Sin asignar</p>
            @endif
        </div>
        <div class="flex flex-col items-end gap-1">
            <a href="{{ route('tasks.show', $task) }}" class="text-xs text-blue-600 dark:text-blue-300 hover:underline">Ver</a>
            <a href="{{ route('tasks.create', ['parent_id' => $task->id]) }}" class="text-xs text-green-600 dark:text-green-300 hover:underline">+ Subtarea</a>
            <a href="{{ route('tasks.edit', $task) }}" class="text-xs text-yellow-600 dark:text-yellow-300 hover:underline">Editar</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="text-xs">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Eliminar tarea?')"
                        class="text-red-600 dark:text-red-300 hover:underline">
                    Borrar
                </button>
            </form>
        </div>
    </div>

    {{-- Subtareas --}}
    @if($task->children->count())
        <div class="mt-2 pl-4 border-l border-gray-200 dark:border-gray-600 text-sm">
            @foreach($task->children as $child)
                @include('tasks._card', ['task' => $child])
            @endforeach
        </div>
    @endif
</div>

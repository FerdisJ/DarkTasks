{{-- resources/views/tasks/show.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold">Detalle tarea</h1>
                <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600">
                    ← Volver al tablero
                </a>
            </div>

            <div class="bg-white shadow rounded p-4 mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    {{ $task->title }}
                    <span class="text-xs ml-2 px-2 py-1 rounded bg-gray-100">
                        {{ $task->status }}
                    </span>
                </h2>

                @if($task->description)
                    <p class="mb-2">{{ $task->description }}</p>
                @endif

                @if($task->start_date || $task->end_date)
                    <p class="text-sm mb-1">
                        <strong>Fechas:</strong>
                        @if($task->start_date)
                            Inicio: {{ $task->start_date->format('d/m/Y') }}
                        @endif
                        @if($task->end_date)
                            · Fin: {{ $task->end_date->format('d/m/Y') }}
                        @endif
                    </p>
                @endif

                @if($task->estimated_hours || $task->actual_hours)
                    <p class="text-sm mb-2">
                        <strong>Horas:</strong>
                        @if($task->estimated_hours)
                            Previstas: {{ $task->estimated_hours }}h
                        @endif
                        @if($task->actual_hours)
                            · Reales: {{ $task->actual_hours }}h
                        @endif
                    </p>
                @endif

                <p class="text-sm mb-1">
                    <strong>Padre:</strong>
                    @if($task->parent)
                        {{ $task->parent->title }}
                    @else
                        Ninguno (tarea raíz)
                    @endif
                </p>

                <p class="text-sm mb-2">
                    <strong>Asignados:</strong>
                    @if($task->users->count())
                        {{ $task->users->pluck('name')->join(', ') }}
                    @else
                        Sin asignar
                    @endif
                </p>

                <div class="flex gap-2 mt-3 text-sm">
                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600">Editar</a>

                    <a href="{{ route('tasks.create', ['parent_id' => $task->id]) }}"
                       class="text-green-600">
                        Añadir subtarea
                    </a>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('¿Eliminar esta tarea y sus subtareas?')"
                                class="text-red-600">
                            Borrar
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-gray-100 p-4 rounded">
                <h3 class="font-semibold mb-2">Subtareas</h3>

                @if($task->children->count())
                    <div class="space-y-2">
                        @foreach($task->children as $child)
                            @include('tasks._card', ['task' => $child])
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600">No hay subtareas.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

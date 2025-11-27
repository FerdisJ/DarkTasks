{{-- resources/views/tasks/edit.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Editar tarea</h1>

                <a href="{{ route('tasks.create', ['parent_id' => $task->id]) }}"
                   class="text-sm bg-green-500 text-white px-3 py-1 rounded">
                    Añadir subtarea
                </a>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Título</label>
                    <input type="text" name="title"
                           value="{{ old('title', $task->title) }}"
                           class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400">
                    @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Descripción</label>
                    <textarea name="description" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400">{{ old('description', $task->description) }}</textarea>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Estado</label>
                    <select name="status" class="border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="TODO"  @selected(old('status', $task->status) === 'TODO')>TODO</option>
                        <option value="DOING" @selected(old('status', $task->status) === 'DOING')>DOING</option>
                        <option value="DONE"  @selected(old('status', $task->status) === 'DONE')>DONE</option>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Fecha de inicio</label>
                        <input type="date" name="start_date"
                               value="{{ old('start_date', optional($task->start_date)->format('Y-m-d')) }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('start_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Fecha de fin</label>
                        <input type="date" name="end_date"
                               value="{{ old('end_date', optional($task->end_date)->format('Y-m-d')) }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('end_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Horas previstas</label>
                        <input type="number" step="0.25" min="0"
                               name="estimated_hours"
                               value="{{ old('estimated_hours', $task->estimated_hours) }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('estimated_hours') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Horas reales</label>
                        <input type="number" step="0.25" min="0"
                               name="actual_hours"
                               value="{{ old('actual_hours', $task->actual_hours) }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('actual_hours') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Tarea padre (opcional)</label>
                    <select name="parent_id" class="border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="">Ninguna (tarea raíz)</option>
                        @foreach($tasks as $t)
                            <option value="{{ $t->id }}"
                                @selected(old('parent_id', $task->parent_id) == $t->id)>
                                {{ $t->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Usuarios asignados (opcional)</label>
                    <select name="users[]" multiple class="w-full border rounded p-2 h-32 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                @selected(in_array($user->id, old('users', $task->users->pluck('id')->toArray())))>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ctrl+click para seleccionar varios.</p>
                </div>

                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Guardar cambios
                </button>

                <a href="{{ route('tasks.index') }}" class="ml-2 text-gray-600 dark:text-gray-400 text-sm">
                    Cancelar
                </a>
            </form>
        </div>
    </div>
</x-app-layout>

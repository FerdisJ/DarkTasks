{{-- resources/views/tasks/create.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-4">Nueva tarea</h1>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Título</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400">
                    @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Descripción</label>
                    <textarea name="description" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Estado</label>
                    <select name="status" class="border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="TODO">TODO</option>
                        <option value="DOING">DOING</option>
                        <option value="DONE">DONE</option>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Fecha de inicio</label>
                        <input type="date" name="start_date"
                               value="{{ old('start_date') }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('start_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Fecha de fin</label>
                        <input type="date" name="end_date"
                               value="{{ old('end_date') }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('end_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Horas previstas</label>
                        <input type="number" step="0.25" min="0"
                               name="estimated_hours"
                               value="{{ old('estimated_hours') }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('estimated_hours') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Horas reales</label>
                        <input type="number" step="0.25" min="0"
                               name="actual_hours"
                               value="{{ old('actual_hours') }}"
                               class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('actual_hours') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Tarea padre (opcional)</label>
                    <select name="parent_id" class="border rounded p-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="">Ninguna (tarea raíz)</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" 
                                @selected(old('parent_id', $parentId ?? null) == $task->id)>
                                {{ $task->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Usuarios asignados (opcional)</label>
                    <select name="users[]" multiple class="w-full border rounded p-2 h-32 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Guardar tarea
                </button>
            </form>
        </div>
    </div>
</x-app-layout>

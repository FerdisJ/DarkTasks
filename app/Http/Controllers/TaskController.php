<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Cargamos tareas raíz (sin parent) con subtareas recursivas y usuarios
        $tasks = Task::whereNull('parent_id')
            ->with(['children.children', 'users']) // puedes profundizar más según necesites
            ->get();

        $users = User::all();

        return view('tasks.index', compact('tasks', 'users'));
    }

    public function create(Request $request)
    {
        $users = User::all();
        $tasks = Task::all(); // para elegir padre si se quiere cambiar
        $parentId = $request->input('parent_id'); // viene de la query

        return view('tasks.create', compact('users', 'tasks', 'parentId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:TODO,DOING,DONE',
            'parent_id'   => 'nullable|exists:tasks,id',
            'users'       => 'array',
            'users.*'     => 'exists:users,id',

            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours'    => 'nullable|numeric|min:0',
        ]);

        $task = Task::create($data);

        if (!empty($data['users'])) {
            $task->users()->sync($data['users']);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada correctamente.');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        $tasks = Task::where('id', '<>', $task->id)->get();

        return view('tasks.edit', compact('task', 'users', 'tasks'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:TODO,DOING,DONE',
            'parent_id'   => 'nullable|exists:tasks,id',
            'users'       => 'array',
            'users.*'     => 'exists:users,id',

            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours'    => 'nullable|numeric|min:0',
        ]);

        $oldStatus = $task->status;

        $task->update($data);
        $task->users()->sync($data['users'] ?? []);

        // Si el estado ha cambiado, actualizar también el de las hijas
        if ($oldStatus !== $task->status) {
            // nos aseguramos de tener las hijas cargadas
            $task->load('children');
            $this->updateChildrenStatus($task, $task->status);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada.');
    }

    // show() lo podrías usar para ver detalle de una tarea concreta
    public function show(Task $task)
    {
        $task->load(['children', 'users', 'parent']);

        return view('tasks.show', compact('task'));
    }

    private function updateChildrenStatus(Task $task, string $status): void
    {
        foreach ($task->children as $child) {
            $child->update(['status' => $status]);

            // Recursivo: aplicar también a las subtareas de este hijo
            $this->updateChildrenStatus($child, $status);
        }
    }
}

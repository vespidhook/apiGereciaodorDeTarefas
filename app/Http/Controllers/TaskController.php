<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->tasks()->get();
    }

    public function show(Request $request, Task $task)
    {
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada.'], 404);
        }

        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        return $task;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        return $request->user()->tasks()->create($data);
    }

    public function update(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        $task->update($request->only('title', 'description', 'is_completed'));
        return $task;
    }

    public function destroy(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        $task->delete();
        return response()->noContent();
    }
}

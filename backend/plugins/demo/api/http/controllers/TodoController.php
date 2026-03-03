<?php namespace Demo\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Demo\Api\Models\Todo;

/**
 * Todo API Controller
 * Full CRUD — create/read/update/delete from Vue.js frontend
 */
class TodoController
{
    public function index(): JsonResponse
    {
        $todos = Todo::orderBy('sort_order')->orderBy('created_at')->get()
            ->map(fn($t) => $t->toApiArray());

        return response()->json(['data' => $todos]);
    }

    public function store(): JsonResponse
    {
        $data = request()->validate(['title' => 'required|string|max:255']);
        $todo = Todo::create($data);

        return response()->json(['data' => $todo->toApiArray()], 201);
    }

    public function update(int $id): JsonResponse
    {
        $todo = Todo::findOrFail($id);
        $todo->update(request()->only(['title', 'done', 'sort_order']));

        return response()->json(['data' => $todo->fresh()->toApiArray()]);
    }

    public function destroy(int $id): JsonResponse
    {
        Todo::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

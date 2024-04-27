<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Mail\TaskReminderMail;
use App\Models\Task;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskService
{
    use ApiResponses;


    public function index($request): JsonResponse
    {
        $per_page = $request->input('per_page', 30);
        $title = $request->input('title', null);
        $due_date = $request->input('due_date', null);
        $status = $request->input('status', null);
        $category_id = $request->input('category_id', null);
        $query = Task::query();
        if ($title) {
            $query = $query->where('title', 'like', '%' . $title . '%');
        }
        if ($status) {
            $query = $query->where('status', $status);
        }
        if ($due_date) {
            $query = $query->where('due_date', $due_date);
        }
        if ($category_id) {
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }
        $tasks = $query->where('user_id', Auth::id())->paginate($per_page);
        return $this->sendResponse('Tasks retrieved successfully!', TaskResource::collection($tasks)->resource);

    }

    public function storeTask($request): JsonResponse
    {
        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description ?? null,
            'tags' => $request->tags,
            'due_date' => $request->due_date ?? null
        ]);
        if ($request->has('category_ids')) {
            $task->categories()->attach(json_decode($request->category_ids, true));
        }
        return $this->sendResponse('Task created successfully!', new TaskResource($task));
    }

    public function updateTask($request, $task): JsonResponse
    {
        $this->checkValidUser($task);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'tags' => $request->tags,
            'due_date' => $request->due_date,
            'status' => $request->status
        ]);
        if ($request->has('category_ids')) {
            $task->categories()->sync(json_decode($request->category_ids, true));
        }
        return $this->sendResponse('Task updated successfully!', new TaskResource($task));
    }

    public function updateTaskStatus($request, $task): JsonResponse
    {
        $this->checkValidUser($task);
        $task->update([
            'status' => $request->status
        ]);
        return $this->sendResponse('Task status updated successfully!', new TaskResource($task));
    }

    public function deleteTask($request, $task): JsonResponse
    {
        $this->checkValidUser($task);
        $task->categories()->detach();
        $task->delete();
        return $this->sendResponse('Task deleted successfully!', new TaskResource($task));
    }

    public function checkValidUser($task): mixed
    {
        if ($task->user_id != Auth::id()) {
            return $this->sendErrors('You are not authorized to update this task!');
        }
        return true;
    }


}

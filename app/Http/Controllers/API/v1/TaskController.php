<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Requests\Task\TaskStatusChangeRequest;

use App\Models\Task;
use App\Services\TaskService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    use  ApiResponses;

    public function index(Request $request, TaskService $taskService): JsonResponse
    {
        return $taskService->index($request);
    }


    public function store(TaskRequest $request, TaskService $taskService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $taskService->storeTask($request->safe());
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }

    public function update(TaskRequest $taskUpdateRequest, TaskService $taskService, Task $task): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $taskService->updateTask($taskUpdateRequest->safe(), $task);
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }

    public function updateTaskStatus(TaskStatusChangeRequest $taskStatusChangeRequest, TaskService $taskService, Task $task): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $taskService->updateTaskStatus($taskStatusChangeRequest->safe(), $task);
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }

    public function destroy(Request $request, Task $task, TaskService $taskService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $taskService->deleteTask($request, $task);
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }

}

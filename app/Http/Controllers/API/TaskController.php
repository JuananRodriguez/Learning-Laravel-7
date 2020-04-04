<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;
use Validator;
use Throwable;
use App\Http\Resources\Task as TaskResource;
use Illuminate\Support\Facades\Cache;

class TaskController extends BaseController
{

    /**
     * Handle class error
     * 
     * 
     */
    private function handleError(Throwable $th)
    {
        if ($th->getCode() == '23000') {
            return $this->sendError('Project not found.', ['Project_id does not correspond to any previously created project'], 400);
        }
        return $this->sendError('Bad request.', '', 400);;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return $this->sendResponse(TaskResource::collection($tasks), 'Task retrieved successfully.');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'project_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', 'Task retrieved successfully.');
        }

        try {
            $task = Task::create($input);
        } catch (Throwable $th) {
            return $this->handleError($th);
        }

        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        return $this->sendResponse(new TaskResource($task), $task->project());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'project_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task->name = $input['name'];
        $task->description = $input['description'];
        $task->project_id = $input['project_id'];


        try {
            $task->save();
        } catch (Throwable $th) {
            return $this->handleError($th);
        }

        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return $this->sendResponse([], 'Task deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Role;
use Validator;
use App\Http\Resources\Role as RoleResource;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return $this->sendResponse(RoleResource::collection($roles), 'Roles retrieved successfully.');
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
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $role = new Role($input);
        $role->save();
        return $this->sendResponse(new RoleResource($role), 'Role created successfully.');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $project = Project::find($id);

    //     if (is_null($project)) {
    //         return $this->sendError('Project not found.');
    //     }

    //     return $this->sendResponse(new ProjectResource($project), 'Project retrieved successfully.');
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Project $project)
    // {
    //     $input = $request->all();

    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'description' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }

    //     $project->name = $input['name'];
    //     $project->description = $input['description'];
    //     $project->save();

    //     return $this->sendResponse(new ProjectResource($project), 'Project updated successfully.');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Project $project)
    // {
    //     $project->delete();

    //     return $this->sendResponse([], 'Project deleted successfully.');
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getProjects();

        return response()->json([
            'status' => 200,
            'message' => 'Projects fetched successfully',
            'projects' => $projects
        ]);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->storeProject($request->validated());

        return response()->json([
            'status' => 201,
            'message' => 'Project created successfully',
            'project' => $project
        ]);
    }

    public function update($projectId, UpdateProjectRequest $request)
    {
        $project = $this->projectService->updateProject($projectId, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'Project updated successfully',
            'project' => $project
        ]);
    }

    public function destroy($projectId)
    {
        $this->projectService->deleteProject($projectId);

        return response()->json([
            'status' => 200,
            'message' => 'Project deleted successfully'
        ]);
    }
}

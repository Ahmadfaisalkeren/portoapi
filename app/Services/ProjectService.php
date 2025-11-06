<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProjectService.
 */
class ProjectService
{
    public function getProjects()
    {
        return Project::all();
    }

    public function storeProject(array $projectData)
    {
        if (isset($projectData['image'])) {
            $projectData['image'] = $this->storeImage($projectData['image']);
        }

        return Project::create($projectData);
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/projects', $imageName, 'public');

        return $imagePath;
    }

    public function updateProject($projectId, array $projectData)
    {
        $project = Project::findOrFail($projectId);

        $project['title'] = $projectData['title'] ?? $project->title;
        $project['description'] = $projectData['description'] ?? $project->description;
        $project['weblink'] = $projectData['weblink'] ?? $project->weblink;

        if (isset($projectData['image'])) {
            $projectData['image'] = $this->updateImage($project, $projectData['image']);
        }

        $project->save();

        return $project;
    }

    private function updateImage(Project $project, $image)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/projects', $imageName, 'public');

            if ($project->image) {
                Storage::delete('public/' . $project->image);
            }

            $project->image = str_replace('public/', '', $imagePath);
        }
    }

    public function deleteProject($projectId)
    {
        $project = Project::find($projectId);

        if ($project->image) {
            $this->deleteImage($project->image);
        }

        return $project->delete();
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }
}

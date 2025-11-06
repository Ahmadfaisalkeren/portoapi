<?php

namespace App\Http\Controllers;

use App\Http\Requests\Skill\StoreSkillRequest;
use App\Http\Requests\Skill\UpdateSkillRequest;
use Illuminate\Http\Request;
use App\Services\SkillService;

class SkillController extends Controller
{
    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index()
    {
        $skills = $this->skillService->getSkills();

        return response()->json([
            'status' => 200,
            'message' => 'Skills fetched successfully',
            'skills' => $skills,
        ]);
    }

    public function store(StoreSkillRequest $request)
    {
        $skill = $this->skillService->storeSkill($request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'Skill created successfully',
            'skill' => $skill,
        ]);
    }

    public function update($skillId, UpdateSkillRequest $request)
    {
        $skill = $this->skillService->updateSkill($skillId, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'Skill updated successfully',
            'skill' => $skill,
        ]);
    }

    public function destroy($skillId)
    {
        $this->skillService->deleteSkill($skillId);

        return response()->json([
            'status' => 200,
            'message' => 'Skill deleted successfully',
        ]);
    }
}

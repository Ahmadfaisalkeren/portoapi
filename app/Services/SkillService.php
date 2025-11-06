<?php

namespace App\Services;

use App\Models\Skill;
use Illuminate\Support\Facades\Storage;

/**
 * Class SkillService.
 */
class SkillService
{
    public function getSkills()
    {
        return Skill::all();
    }

    public function storeSkill(array $skillData)
    {
        if (isset($skillData['image'])) {
            $skillData['image'] = $this->storeImage($skillData['image']);
        }

        return Skill::create($skillData);
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/skills', $imageName, 'public');

        return $imagePath;
    }

    public function updateSkill($skillId, array $skillData)
    {
        $skill = Skill::findOrFail($skillId);

        $skill->skill = $skillData['skill'] ?? $skill->skill;
        $skill->description = $skillData['description'] ?? $skill->description;

        if (isset($skillData['image'])) {
            $skill->image = $this->updateImage($skill, $skillData['image']);
        }

        $skill->save();

        return $skill;
    }

    private function updateImage(Skill $skill, $image)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/skills', $imageName, 'public');

            if ($skill->image) {
                Storage::disk('public')->delete($skill->image);
            }

            return $imagePath;
        }

        return $skill->image;
    }

    public function deleteSkill($skillId)
    {
        $skill = Skill::findOrFail($skillId);

        if ($skill->image) {
            $this->deleteImage($skill->image);
        }

        return $skill->delete();
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}

<?php

namespace App\Services;

use App\Models\About;
use App\Models\Certificate;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Skill;

/**
 * Class AllDataService.
 */
class AllDataService
{
    public function getAllData()
    {
        $about = About::all();
        $certificate = Certificate::all();
        $contact = Contact::all();
        $project = Project::all();
        $skills = Skill::all();

        return [
            'about' => $about,
            'certificate' => $certificate,
            'contact' => $contact,
            'project' => $project,
            'skills' => $skills
        ];
    }
}

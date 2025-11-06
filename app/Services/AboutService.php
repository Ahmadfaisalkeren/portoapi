<?php

namespace App\Services;

use App\Models\About;

/**
 * Class AboutService.
 */
class AboutService
{
    public function getAboutData()
    {
        return About::orderBy('id', 'desc')->get();
    }

    public function storeAbout(array $aboutData)
    {
        return About::create($aboutData);
    }

    public function updateAbout($aboutId, array $aboutData)
    {
        $about = About::find($aboutId);

        return $about->update($aboutData);
    }

    public function deleteAbout($aboutId)
    {
        $about = About::find($aboutId);

        return $about->delete();
    }
}

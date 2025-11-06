<?php

namespace App\Http\Controllers;

use App\Http\Requests\About\StoreAboutRequest;
use App\Http\Requests\About\UpdateAboutRequest;
use App\Services\AboutService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    public function index()
    {
        $abouts = $this->aboutService->getAboutData();

        return response()->json([
            'status' => 200,
            'message' => 'About fetched successfully',
            'abouts' => $abouts,
        ], 200);
    }

    public function store(StoreAboutRequest $request)
    {
        $about = $this->aboutService->storeAbout($request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'About created successfully',
            'about' => $about,
        ]);
    }

    public function update(UpdateAboutRequest $request, $aboutId)
    {
        $about = $this->aboutService->updateAbout($aboutId, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'About updated successfully',
            'about' => $about,
        ]);
    }

    public function destroy($aboutId)
    {
        $about = $this->aboutService->deleteAbout($aboutId);

        return response()->json([
            'status' => 200,
            'message' => 'About deleted successfully',
            'about' => $about,
        ]);
    }
}

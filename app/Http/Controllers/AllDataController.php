<?php

namespace App\Http\Controllers;

use App\Services\AllDataService;
use Illuminate\Http\Request;

class AllDataController extends Controller
{
    protected $allDataService;

    public function __construct(AllDataService $allDataService)
    {
        $this->allDataService = $allDataService;
    }

    public function index()
    {
        $allData = $this->allDataService->getAllData();

        return response()->json([
            'status' => 200,
            'message' => 'All data fetched successfully',
            'allData' => $allData
        ]);
    }
}

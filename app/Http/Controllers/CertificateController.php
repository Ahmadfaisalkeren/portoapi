<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CertificateService;
use App\Http\Requests\Certificate\StoreCertificateRequest;
use App\Http\Requests\Certificate\UpdateCertificateRequest;

class CertificateController extends Controller
{
    protected $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function index()
    {
        $certificates = $this->certificateService->getCertificates();

        return response()->json([
            'status' => 200,
            'message' => 'Certificates fetched successfully',
            'certificates' => $certificates
        ]);
    }

    public function store(StoreCertificateRequest $request)
    {
        $certificate = $this->certificateService->storeCertificate($request->validated());

        return response()->json([
            'status' => 201,
            'message' => 'Certificate created successfully',
            'certificate' => $certificate
        ]);
    }

    public function update($certificateId, UpdateCertificateRequest $request)
    {
        $certificate = $this->certificateService->updateCertificate($certificateId, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'Certificate updated successfully',
            'certificate' => $certificate
        ]);
    }

    public function destroy($certificateId)
    {
        $this->certificateService->deleteCertificate($certificateId);

        return response()->json([
            'status' => 200,
            'message' => 'Certificate deleted successfully'
        ]);
    }

}

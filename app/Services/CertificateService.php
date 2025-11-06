<?php

namespace App\Services;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;

/**
 * Class CertificateService.
 */
class CertificateService
{
    public function getCertificates()
    {
        return Certificate::all();
    }

    public function storeCertificate(array $certificateData)
    {
        if (isset($certificateData['image'])) {
            $certificateData['image'] = $this->storeImage($certificateData['image']);
        }

        return Certificate::create($certificateData);
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/certificates', $imageName, 'public');

        return $imagePath;
    }

    public function updateCertificate($certificateId, array $certificateData)
    {
        $certificate = Certificate::findOrFail($certificateId);

        $certificate->title = $certificateData['title'] ?? $certificate->title;
        $certificate->year = $certificateData['year'] ?? $certificate->year;

        if (isset($certificateData['image'])) {
            $certificate->image = $this->updateImage($certificate, $certificateData['image']);
        }

        $certificate->save();

        return $certificate;
    }

    private function updateImage(Certificate $certificate, $image)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/certificates', $imageName, 'public');

            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }

            return $imagePath;
        }

        return $certificate->image;
    }

    public function deleteCertificate($certificateId)
    {
        $certificate = Certificate::findOrFail($certificateId);

        if ($certificate->image) {
            $this->deleteImage($certificate->image);
        }

        return $certificate->delete();
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}

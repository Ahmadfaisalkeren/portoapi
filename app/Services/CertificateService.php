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
        $certificate = Certificate::find($certificateId);

        $certificate['title'] = $certificateData['title'] ?? $certificate->title;
        $certificate['year'] = $certificateData['year'] ?? $certificate->year;

        if (isset($certificateData['image'])) {
            $certificateData['image'] = $this->updateImage($certificate, $certificateData['image']);
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
                Storage::delete('public/' . $certificate->image);
            }

            $certificate->image = str_replace('public/', '', $imagePath);
        }
    }

    public function deleteCertificate($certificateId)
    {
        $certificate = Certificate::find($certificateId);

        if ($certificate->image) {
            $this->deleteImage($certificate->image);
        }

        return $certificate->delete();
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }

}

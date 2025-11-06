<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

/**
 * Class ContactService.
 */
class ContactService
{
    public function getContacts()
    {
        return Contact::all();
    }

    public function storeContact(array $contactData)
    {
        if (isset($contactData['image'])) {
            $contactData['image'] = $this->storeImage($contactData['image']);
        }

        return Contact::create($contactData);
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/contacts', $imageName, 'public');

        return $imagePath;
    }

    public function updateContact($contactId, array $contactData)
    {
        $contact = Contact::findOrFail($contactId);

        $contact->title = $contactData['title'] ?? $contact->title;
        $contact->link = $contactData['link'] ?? $contact->link;

        if (isset($contactData['image'])) {
            $contact->image = $this->updateImage($contact, $contactData['image']);
        }

        $contact->save();

        return $contact;
    }

    private function updateImage(Contact $contact, $image)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/contacts', $imageName, 'public');

            if ($contact->image) {
                Storage::disk('public')->delete($contact->image);
            }

            return $imagePath;
        }

        return $contact->image;
    }

    public function deleteContact($contactId)
    {
        $contact = Contact::findOrFail($contactId);

        if ($contact->image) {
            $this->deleteImage($contact->image);
        }

        return $contact->delete();
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}

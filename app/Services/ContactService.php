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
        $contact = Contact::find($contactId);

        $contact['title'] = $contactData['title'] ?? $contact->title;
        $contact['link'] = $contactData['link'] ?? $contact->link;

        if (isset($contactData['image'])) {
            $contactData['image'] = $this->updateImage($contact, $contactData['image']);
        }

        $contact->update($contactData);

        return $contact;
    }

    private function updateImage(Contact $contact, $image)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/contacts', $imageName, 'public');

            if ($contact->image) {
                Storage::delete('public/' . $contact->image);
            }

            $contact->image = str_replace('public/', '', $imagePath);
        }
    }

    public function deleteContact($contactId)
    {
        $contact = Contact::find($contactId);

        if ($contact->image) {
            $this->deleteImage($contact->image);
        }

        return $contact->delete();
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        $contacts = $this->contactService->getContacts();

        return response()->json([
            'status' => 200,
            'message' => 'Contacts fetched successfully',
            'contacts' => $contacts
        ]);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = $this->contactService->storeContact($request->validated());

        return response()->json([
            'status' => 201,
            'message' => 'Contact created successfully',
            'contact' => $contact
        ]);
    }

    public function update($contactId, UpdateContactRequest $request)
    {
        $contact = $this->contactService->updateContact($contactId, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'Contact updated successfully',
            'contact' => $contact
        ]);
    }

    public function destroy($contactId)
    {
        $this->contactService->deleteContact($contactId);

        return response()->json([
            'status' => 200,
            'message' => 'Contact deleted successfully'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Interfaces\ContactInterfaceRepository;
use App\Classes\ApiResponse;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    private ContactInterfaceRepository $contactInterfaceRepository;

    public function __construct(ContactInterfaceRepository $contactInterfaceRepository)
    {
        $this->contactInterfaceRepository = $contactInterfaceRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = $this->contactInterfaceRepository->index();

        return ApiResponse::sendResponse($contacts, "", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $details = [
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "user_id" => Auth::id()
        ];

        DB::beginTransaction();
        try {
            $result = $this->contactInterfaceRepository->store($details);
            DB::commit();

            return ApiResponse::sendResponse($result, "Contact created successfully", 201);
        } catch (\Exception $ex) {
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = $this->contactInterfaceRepository->getById($id);
        //Policy
        $this->authorize('view', $contact);

        return ApiResponse::sendResponse(new ContactResource($contact), "", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, $id)
    {
        //Policy
        $contact = $this->contactInterfaceRepository->getById($id);
        $this->authorize('update', $contact);

        $details = array_filter([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
        ], fn($value) => !is_null($value));

        DB::beginTransaction();
        try {
            $result = $this->contactInterfaceRepository->update($details, $id);

            if (!$result) {
                return ApiResponse::sendResponse([], "Contact not found", 404);
            }

            DB::commit();

            return ApiResponse::sendResponse($result, "Contact updated successfully", 201);
        } catch (\Exception $ex) {
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Policy
        $contact = $this->contactInterfaceRepository->getById($id);
        $this->authorize('delete', $contact);

        $this->contactInterfaceRepository->delete($id);

        return ApiResponse::sendResponse("Contact deleted successfully", "", 200);
    }
}

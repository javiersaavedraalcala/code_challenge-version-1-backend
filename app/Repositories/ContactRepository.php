<?php

namespace App\Repositories;

use App\Interfaces\ContactInterfaceRepository;
use App\Models\Contact;

class ContactRepository implements ContactInterfaceRepository
{
    public function index()
    {
        return Contact::all();
    }

    public function getById($id)
    {
        return Contact::findOrFail($id);
    }

    public function store(array $data)
    {
        return Contact::create($data);
    }

    public function update(array $data, $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return false;
        }

        $contact->update($data);

        return $contact;
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->destroy($id);

        return $contact;
    }
}

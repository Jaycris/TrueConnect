<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\ContactNumber;
use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip header row
        if ($row[0] === 'First Name') {
            return null;
        }

        // Check for required 'email' field
        // if (empty($row[3])) {
        //     throw ValidationException::withMessages([
        //         'error' => "Missing email for lead {$row[0]} {$row[2]}",
        //     ]);
        // }

        
        // Validate email format
        // if (!filter_var($row[3], FILTER_VALIDATE_EMAIL)) {
        //     throw ValidationException::withMessages([
        //         'error' => "Invalid email format: {$row[3]}",
        //     ]);
        // }
        
        // Check for duplicate email
        // if (Customer::where('email', $row[3])->exists()) {
        //     throw ValidationException::withMessages([
        //         'error' => "Email {$row[3]} already exists.",
        //     ]);
        // }

        // Check if lead already exists
        $existingCustomer = Customer::where('first_name', $row[0])
                                    ->where('last_name', $row[2])
                                    ->exists();

        if ($existingCustomer) {
            throw ValidationException::withMessages([
                'error' => "<br>Lead {$row[0]} {$row[2]} already exists.",
            ]);
        }


        $customer = new Customer([
            'first_name'        => $row[0],
            'middle_name'       => $row[1] ?? null,
            'last_name'         => $row[2],
            'email'             => $row[3],
            'address'           => $row[4] ?? null,
            'website'           => $row[5] ?? null,
            'date_created'      => now(),
            'lead_miner'        => Auth::id(),
        ]);

        $customer->save();

        // Save contact numbers (Column 6 - comma-separated)
        if (!empty($row[6])) {
            $contactNumbers = explode(',', $row[6]);
            foreach ($contactNumbers as $contact) {
                $customer->contactNumbers()->create([
                    'contact_number' => trim($contact),
                    'status' => 'Not Verified'
                ]);
            }
        }

        // Save books (Columns 7 & 14 - comma-separated)
        if (!empty($row[7])) {
            $bookTitles = explode(',', $row[7]);
            $bookLinks = isset($row[8]) ? explode(',', $row[8]) : [];

            foreach ($bookTitles as $index => $title) {
                $customer->books()->create([
                    'title' => trim($title),
                    'link'  => $bookLinks[$index] ?? null, // Match titles with links if available
                ]);
            }
        }

        return $customer;
    }
}

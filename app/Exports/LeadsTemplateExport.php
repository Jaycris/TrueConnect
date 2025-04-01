<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsTemplateExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'First Name',
            'Middle Name',
            'Last Name',
            'Email',
            'Address',
            'Website',
            'Contact Numbers (comma-separated)',
            'Book (comma-separated)',
            'Book Links (comma-separated)',
        ];
    }
}

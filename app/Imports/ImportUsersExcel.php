<?php

namespace App\Imports;

use App\Models\ImportUser;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportUsersExcel implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ImportUser([
            'first_name'  => $row['first_name'] ?? null,
            'middle_name' => $row['middle_name'] ?? null,
            'email'       => $row['email'] ?? null,
            'mobile'      => $row['mobile'] ?? null,
            'password'    => isset($row['password']) ? Hash::make($row['password']) : null,
        ]);
    }
}

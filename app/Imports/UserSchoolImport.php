<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserSchoolImport implements WithMultipleSheets
{
    public $data = [];

    /**
     * 
     */
    public function sheets(): array
    {
        return [
            'Students' => new class($this->data) implements ToCollection, WithStartRow {
                private $data;
                public function __construct(&$data) {
                    $this->data = &$data;
                }

                public function startRow(): int
                {
                    return 2; // تخطي الصف الأول
                }

                public function collection(Collection $rows)
                {
                    $this->data['Students'] = $rows->map(function ($row) {
                        return [
                            'name' => $row[0] ?? null,
                            'email' => $row[1] ?? null,
                            'code' => $row[2] ?? null,
                            'phone' => $row[3] ?? null,
                            'semester' => $row[4] ?? null,
                        ];
                    })->toArray();
                }
            },

            'Guardians' => new class($this->data) implements ToCollection, WithStartRow {
                private $data;
                public function __construct(&$data) {
                    $this->data = &$data;
                }

                public function startRow(): int
                {
                    return 2;
                }

                public function collection(Collection $rows)
                {
                    $this->data['Guardians'] = $rows->map(function ($row) {
                        return [
                            'name' => $row[0] ?? null,
                            'email' => $row[1] ?? null,
                            'phone' => $row[2] ?? null,
                            'student_codes' => $row[3] ?? null,
                        ];
                    })->toArray();
                }
            },

            'Teachers' => new class($this->data) implements ToCollection, WithStartRow {
                private $data;
                public function __construct(&$data) {
                    $this->data = &$data;
                }

                public function startRow(): int
                {
                    return 2;
                }

                public function collection(Collection $rows)
                {
                    $this->data['Teachers'] = $rows->map(function ($row) {
                        return [
                            'name' => $row[0] ?? null,
                            'email' => $row[1] ?? null,
                            'phone' => $row[2] ?? null,
                            'semesters' => $row[3] ?? null,
                            'section' => $row[4] ?? null,
                            'job_number' => $row[5] ?? null,
                            'job_title' => $row[6] ?? null,
                        ];
                    })->toArray();
                }
            },
        ];
    }
}

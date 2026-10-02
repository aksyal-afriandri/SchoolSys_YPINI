<?php

namespace App\Imports;

use App\Models\SiswaModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;

    public int $skipped = 0;

    public bool $foundHeaders = false;

    private array $seenNisn = [];

    public function headingRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            return;
        }

        $headers = array_keys($rows->first()->toArray());
        if (! in_array('nisn', $headers, true) || ! in_array('nama', $headers, true)) {
            return;
        }

        $this->foundHeaders = true;

        foreach ($rows as $index => $row) {
            $nisn = trim((string) ($row['nisn'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($nisn === '' && $nama === '') {
                continue;
            }

            $validator = Validator::make(
                ['nisn' => $nisn, 'nama' => $nama],
                ['nisn' => 'required|string|max:255', 'nama' => 'required|string|max:255']
            );

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'file' => 'Baris Excel '.($index + 3).': '.implode(' ', $validator->errors()->all()),
                ]);
            }

            if (isset($this->seenNisn[$nisn]) || SiswaModel::where('nisn', $nisn)->exists()) {
                $this->skipped++;
                continue;
            }

            SiswaModel::create(['nisn' => $nisn, 'nama' => $nama]);
            $this->seenNisn[$nisn] = true;
            $this->imported++;
        }
    }
}
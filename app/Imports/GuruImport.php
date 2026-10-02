<?php

namespace App\Imports;

use App\Models\GuruModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GuruImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public int $skipped = 0;
    public bool $foundHeaders = false;
    public array $seenNip = [];
    public function headingRow(): int
    {
        return 2;
    }
    public function collection(Collection $collection)
    {
        if ($collection->isEmpty()) {
            return;
        }

        $headers = array_keys($collection->first()->toArray());
        if (! in_array('nip', $headers, true) || ! in_array('nama', $headers, true)) {
            return;
        }

        $this->foundHeaders = true;

        foreach ($collection as $index => $row) {
            $nip = trim((string) ($row['nip'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($nip === '' && $nama === '') {
                continue;
            }

            $validator = Validator::make(
                ['nip' => $nip, 'nama' => $nama],
                ['nip' => 'required|string|max:255', 'nama' => 'required|string|max:255']
            );

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'file' => 'Baris Excel '.($index + 3).': '.implode(' ', $validator->errors()->all()),
                ]);
            }

            if (isset($this->seenNip[$nip]) || GuruModel::where('nip', $nip)->exists()) {
                $this->skipped++;
                continue;
            }

            GuruModel::create(['nip' => $nip, 'nama' => $nama]);
            $this->seenNip[$nip] = true;
            $this->imported++;
        }
    }
}

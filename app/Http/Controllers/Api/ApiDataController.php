<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\PelajaranModel;
use App\Models\SiswaModel;
use App\Models\TahunAjaranModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApiDataController extends Controller
{
    private const RESOURCES = [
        'siswa' => [SiswaModel::class, 'data_siswa', ['nisn', 'nama']],
        'guru' => [GuruModel::class, 'data_guru', ['nip', 'nama']],
        'kelas' => [KelasModel::class, 'data_kelas', ['nama_kelas']],
        'pelajaran' => [PelajaranModel::class, 'data_pelajaran', ['nama_pelajaran']],
        'tahun' => [TahunAjaranModel::class, 'tahun_ajaran', ['tahun_ajaran']],
    ];

    public function index(string $resource): JsonResponse
    {
        [$model] = $this->resourceConfig($resource);
        $records = $model::query()->orderBy('id')->get();

        return response()->json([
            'data' => $records->map(fn (Model $record) => $this->formatRecord($resource, $record)),
        ]);
    }

    public function show(string $resource, int $id): JsonResponse
    {
        [$model] = $this->resourceConfig($resource);
        $record = $model::query()->findOrFail($id);

        return response()->json(['data' => $this->formatRecord($resource, $record)]);
    }

    public function photo(int $id)
    {
        $student = SiswaModel::query()->findOrFail($id);

        abort_unless(
            $student->photo && Storage::disk('public')->exists($student->photo),
            404,
            'Foto siswa tidak ditemukan.'
        );

        return response()->file(Storage::disk('public')->path($student->photo));
    }

    public function store(Request $request, string $resource): JsonResponse
    {
        [$model] = $this->resourceConfig($resource);
        $record = new $model();
        $data = $this->validatedData($request, $resource);
        unset($data['photo']);
        $record->fill($data);
        $this->storePhoto($request, $resource, $record);
        $record->save();

        return response()->json(['data' => $this->formatRecord($resource, $record)], 201);
    }

    public function update(Request $request, string $resource, int $id): JsonResponse
    {
        [$model] = $this->resourceConfig($resource);
        $record = $model::query()->findOrFail($id);
        $data = $this->validatedData($request, $resource, $record);
        unset($data['photo']);
        $record->fill($data);
        $this->storePhoto($request, $resource, $record);
        $record->save();

        return response()->json(['data' => $this->formatRecord($resource, $record)]);
    }

    public function destroy(string $resource, int $id): JsonResponse
    {
        [$model] = $this->resourceConfig($resource);
        $record = $model::query()->findOrFail($id);

        if ($resource === 'siswa' && $record->photo) {
            Storage::disk('public')->delete($record->photo);
        }

        $record->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    private function resourceConfig(string $resource): array
    {
        abort_unless(isset(self::RESOURCES[$resource]), 404, 'Jenis data tidak ditemukan.');

        return self::RESOURCES[$resource];
    }

    private function validatedData(Request $request, string $resource, ?Model $record = null): array
    {
        [, $table, $fields] = $this->resourceConfig($resource);
        $rules = [];

        foreach ($fields as $field) {
            $rules[$field] = [
                $record ? 'sometimes' : 'required',
                'required',
                'string',
                'max:255',
            ];

            if (in_array($field, ['nisn', 'nip'], true)) {
                $rules[$field][] = Rule::unique($table, $field)->ignore($record?->getKey());
            }
        }

        if ($resource === 'siswa') {
            $rules['photo'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'];
        }

        return $request->validate($rules);
    }

    private function storePhoto(Request $request, string $resource, Model $record): void
    {
        if ($resource !== 'siswa' || ! $request->hasFile('photo')) {
            return;
        }

        if ($record->photo) {
            Storage::disk('public')->delete($record->photo);
        }

        $record->photo = $request->file('photo')->store('siswa', 'public');
    }

    private function formatRecord(string $resource, Model $record): array
    {
        $data = $record->toArray();

        if ($resource === 'siswa') {
            $data['photo_endpoint'] = $record->photo && Storage::disk('public')->exists($record->photo)
                ? '/data/siswa/'.$record->id.'/photo'
                : null;
        }

        return $data;
    }
}
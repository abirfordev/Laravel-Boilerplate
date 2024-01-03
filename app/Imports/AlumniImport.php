<?php

namespace App\Imports;

use App\Models\Alumni;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AlumniImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            try {
                $alumni = new Alumni();
                $alumni->student_id = $value['student_id'];
                $alumni->name = $value['name'];
                $alumni->password = Hash::make('123456');
                $alumni->save();
            } catch (Exception $e) {
            }
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
}

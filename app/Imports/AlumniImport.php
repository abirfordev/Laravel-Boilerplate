<?php

namespace App\Imports;

use App\Mail\WelcomeMail;
use App\Models\Alumni;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToCollection, WithHeadingRow
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
                if ($alumni->save()) {
                    $email = 'abirdas422@gmail.com';

                    $mailData = [
                        'title' => 'Welcome mail',
                        'url' => 'http://127.0.0.1:8000/user/login',
                        'name' => $value['name'],
                        'student_id' => $value['student_id'],
                        'password' => '123456'
                    ];

                    Mail::to($email)->send(new WelcomeMail($mailData));
                }
            } catch (Exception $e) {
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mail_types')->truncate();

        $mailTypes = [
            'Surat Keterangan Ahli Waris',
            'Surat Keterangan Belum Menikah',
            'Surat Pindah'
        ];

        $now = Carbon::now();
        $data = [];

        foreach ($mailTypes as $type) {
            $data[] = [
                'type_name' => $type,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('mail_types')->insert($data);
    }
}

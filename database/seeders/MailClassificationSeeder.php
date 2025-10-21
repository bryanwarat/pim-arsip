<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MailClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mail_classifications')->truncate();
        
        $classifications = [
            'Biasa',
            'Rahasia',
            'Sangat Rahasia',
            'Terbatas',
            'Penting',
        ];

        $now = Carbon::now();
        $data = [];

        foreach ($classifications as $classification) {
            $data[] = [
                'classification_name' => $classification,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Memasukkan data ke tabel mail_classifications
        DB::table('mail_classifications')->insert($data);
    }
}

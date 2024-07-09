<?php

namespace Database\Seeders;

use App\Models\Header;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headers = [
            [
                'DIES NATALIS Ke - 12 PERMIKOMNAS',
                ''
            ],
            [
                'PEKAN ESPORT Vol. 2',
                'pekanesport'
            ],
            [
                'PENGURUS',
                'structure'
            ],
            [
                'PROGRAM KERJA',
                'workplan'
            ],
            [
                'ARTIKEL',
                'article'
            ],
            [
                'DOKUMENTASI',
                'gallery'
            ]
        ];

        foreach ($headers as $key => $value) {
            Header::create([
                'title' => $value[0],
                'url' => $value[1],
                'rank' => $key
            ]);
        }
    }
}

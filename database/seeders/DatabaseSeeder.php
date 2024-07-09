<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BoardSeeder::class,
            AdminSeeder::class,
            DivisionSeeder::class,
            MemberDivisionSeeder::class,
            CategoryGallerySeeder::class,
            GallerySeeder::class,
            ArticleCategorySeeder::class,
            WorkplanSeeder::class,
            CaborSeeder::class,
            ContentSeeder::class,
            HeaderSeeder::class,
        ]);
    }
}

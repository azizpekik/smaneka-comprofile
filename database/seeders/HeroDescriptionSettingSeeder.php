<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class HeroDescriptionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert hero_description setting only if not exists
        Setting::firstOrCreate(
            ['key' => 'hero_description'],
            [
                'value' => 'SMANeka berkomitmen mencetak lulusan yang tidak hanya unggul dalam akademik, tetapi juga memiliki karakter kuat dan siap menghadapi tantangan masa depan.',
                'type' => 'textarea',
            ]
        );

        $this->command->info('✅ Setting hero_description berhasil ditambahkan!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::query()->firstOrCreate([
            'name' => 'site percentage',
            'type' => 'number',
            'slug' => 'نسبه الموقع',
        ],
            ['value' => 1]
        );
        Setting::query()->firstOrCreate([
            'name' => 'tax percentage',
            'type' => 'number',
            'slug' => 'نسبه الضريبه',
        ],
            ['value' => 1]
        );
        Setting::firstOrCreate([
            'name' => 'active min price',
            'slug' => 'تفعيل الحد الادنى',
            'type' => 'select',
            'options' => [
                ['label' => 'غير مفعل', 'value' => 0],
                ['label' => ' مفعل', 'value' => 1],
            ],
        ], ['value' => 1,]);
        Setting::firstOrCreate([
            'name' => 'about',
            'slug' => 'عن الموقع',
            'type' => 'textarea',
        ],
            ['value' => 'عن الموقع',
            ]);
        Setting::firstOrCreate([
            'name' => 'period to accept order',
            'slug' => 'الفتره الزمنيه المسموح خلالها قبول الطلب',
            'type' => 'number',
        ],
            [
                'value' => '1',
            ]);
    }
}

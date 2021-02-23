<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->AgentPermission();
        $this->AdminPermission();
    }

    public function AgentPermission(): void
    {
        $actions = ['create' => 'اضاقه', 'view' => 'مشاهدة', 'edit' => 'تعديل', 'delete' => 'حذف'];

        $agent_models = [
            'Delivery' => 'المندوبين',
            'Order' => 'الطلبات',
            'AgentProduct' => 'المنتجات',

        ];

        $ids = [];

        foreach ($agent_models as $en => $ar) {

            foreach ($actions as $en_action => $ar_action) {
                $attributes = [
                    'name' => Str::title("{$en_action} {$en}"),
                    'label_ar' => "{$ar_action} {$ar}",
                    'label_en' => Str::title("{$en_action} {$en}"),
                    'group_name' => Str::plural($en),
                    'guard_name' => 'agent',
                ];
                $permission = \App\Models\Permission::firstOrCreate($attributes, $attributes);

                $ids[] = $permission->id;
            }
        }

        $ids[] = Permission::firstOrCreate([
            'name' => Str::title("Accept Delivery"),
            'label_ar' => "قبول المندوبين",
            'label_en' => Str::title("Accept Delivery"),
            'group_name' => 'Others',
            'guard_name' => 'agent'])->id;
        Permission::whereNotIn('id', $ids)->where('guard_name', 'agent')->delete();
    }

    public function AdminPermission(): void
    {
        $actions = ['create' => 'اضاقه', 'view' => 'مشاهدة', 'edit' => 'تعديل', 'delete' => 'حذف'];

        $agent_models = [
            'Admin' => 'المديرين',
            'User' => 'المستخدمين',
            'Agent' => 'الوكلاء',
            "Delivery" => 'المندوبين',
            "Order" => 'الطلبات',
            "Category" => 'الاقسام',
            "Mark" => 'الماركات',
            "City" => 'المدن',
            "CarType" => 'انواع السيارات',
            "Product" => 'المنتجات',
            "Address" => 'العنواين',
//            "Setting" => 'الاعدادت',
            "Contact" => 'تواصل معنا',
            "Roles" => 'الصلاحيات والادوار',
            "PromoCode" => 'كوبونات الصخم',
            "Provider" => 'مزودين الخدمات',
        ];

        $ids = [];

        foreach ($agent_models as $en => $ar) {

            foreach ($actions as $en_action => $ar_action) {
                $attributes = [
                    'name' => Str::title("{$en_action} {$en}"),
                    'label_ar' => "{$ar_action} {$ar}",
                    'label_en' => Str::title("{$en_action} {$en}"),
                    'group_name' => Str::plural($en),
                    'guard_name' => 'admin',
                ];
                $permission = \App\Models\Permission::query()->firstOrCreate($attributes, $attributes);

                $ids[] = $permission->id;
            }
        }

        $ids[] = Permission::query()->firstOrcreate([
            'name' => Str::title("Accept Delivery"),
            'label_ar' => "قبول المندوبين",
            'label_en' => Str::title("Accept Delivery"),
            'group_name' => 'Others',
            'guard_name' => 'admin'])->id;
        $ids[] = Permission::query()->firstOrcreate([
            'name' => Str::title("Show Settings"),
            'label_ar' => "مشاهده الاعدادات",
            'label_en' => Str::title("Show Settings"),
            'group_name' => 'Settings',
            'guard_name' => 'admin'])->id;
        $ids[] = Permission::query()->firstOrcreate([
            'name' => Str::title("Edit Settings"),
            'label_ar' => "تعديل الاعدادات",
            'label_en' => Str::title("Edit Settings"),
            'group_name' => 'Settings',
            'guard_name' => 'admin'])->id;


        Permission::whereNotIn('id', $ids)->where('guard_name', 'admin')->delete();
    }
}

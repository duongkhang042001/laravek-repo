<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     // $partner = Partner::create([
    //     //     'id' => 4581,
    //     //     'name' => 'CÔNG TY CỔ PHẦN CÔNG NGHỆ & THỜI TRANG TÂM AN',
    //     //     'enabled' => 1,
    //     //     'created_at' => date('Y-m-d H:i:s'),
    //     //     'updated_at' => date('Y-m-d H:i:s'),
    //     // ]);

    //     $arrayOfPermissionNames = [
    //         'dashboard.index',
    //         'users.index', //quản lý tk
    //         'users.store',
    //         'users.update',
    //         'users.destroy',
    //         'campaigns.index',
    //         'campaigns.store',
    //         'campaigns.update',
    //         'campaigns.destroy',
    //         'campaigns.import',
    //         'campaigns.approve',
    //         'templates.index',
    //         'templates.store',
    //         'templates.update',
    //         'templates.destroy',
    //         'reports.index',
    //         'messages.index',
    //         'messages.export',
    //     ];

    //     $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
    //         return [
    //             'name' => $permission,
    //             'guard_name' => 'api',
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //         ];
    //     });

    //     foreach ($permissions as $permission) {
    //         Permission::updateOrInsert(
    //             ['name' => $permission['name']],
    //             $permission
    //         );
    //     }

    //     $arrayOfRoleNames = [
    //         'Brandname',
    //         'MOMT'
    //     ];

    //     $roles = collect($arrayOfRoleNames)->map(function ($role) {
    //         return [
    //             'name' => $role,
    //             'guard_name' => 'api',
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //         ];
    //     });

    //     foreach ($roles as $role) {
    //         $model = Role::updateOrCreate(
    //             ['name' => $role['name']],
    //             $role
    //         );

    //         $model->syncPermissions([
    //             'users.index',
    //             'users.store',
    //             'users.update',
    //             'users.destroy',
    //             'reports.index',
    //             'messages.index'
    //         ]);
    //     }

    //     $roles = \App\Models\Auth\Role::get();

    //     // $partner->roles()->sync($roles);

    //     // $menus = [
    //     //     [
    //     //         'name' => 'Dashboard',
    //     //         'sub' => [],
    //     //     ],
    //     //     [
    //     //         'name' => 'Quản lý tài khoản',
    //     //         'sub' => [
    //     //             [
    //     //                 'name' => 'My profile',
    //     //                 'sub' => [],
    //     //             ],
    //     //             [
    //     //                 'name' => 'Sub accounts',
    //     //                 'pers' => 'users.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //         ],
    //     //     ],
    //     //     [
    //     //         'name' => 'Báo cáo SMS',
    //     //         'pers' => 'reports.index',
    //     //         'sub' => [
    //     //             [
    //     //                 'name' => 'Báo cáo sản lượng theo ngày',
    //     //                 'pers' => 'reports.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //             [
    //     //                 'name' => 'Báo cáo sản lượng theo cú pháp',
    //     //                 'pers' => 'reports.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //             [
    //     //                 'name' => 'Báo cáo sản lượng theo cú pháp con',
    //     //                 'pers' => 'reports.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //             [
    //     //                 'name' => 'Báo cáo sản lượng tin nhắn chủ động',
    //     //                 'pers' => 'reports.index',
    //     //                 'sub' => [],
    //     //             ],

    //     //         ],
    //     //     ],
    //     //     [
    //     //         'name' => 'Tra cứu SMS',
    //     //         'pers' => 'messages.index',
    //     //         'sub' => [
    //     //             [
    //     //                 'name' => 'Tra cứu tin nhắn',
    //     //                 'pers' => 'messages.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //             [
    //     //                 'name' => 'Tra cứu tin nhắn chủ động',
    //     //                 'pers' => 'messages.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //         ],
    //     //     ],
    //     //     [
    //     //         'name' => 'Brandname tools',
    //     //         'pers' => 'campaigns.index,messages.index',
    //     //         'sub' => [
    //     //             [
    //     //                 'name' => 'Quản lý chiến dịch',
    //     //                 'pers' => 'campaigns.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //             [
    //     //                 'name' => 'Quản lý mẫu tin nhắn',
    //     //                 'pers' => 'messages.index',
    //     //                 'sub' => [],
    //     //             ],
    //     //         ],
    //     //     ],
    //     // ];


    //     // foreach ($menus as $menu) {

    //     //     $main = $partner->menus()->create([
    //     //         'name' => $menu['name'],
    //     //         'pers' => @$menu['pers']
    //     //     ]);

    //     //     if ($menu['sub']) {
    //     //         foreach ($menu['sub'] as $sub) {
    //     //             $partner->menus()->create([
    //     //                 'name' => $sub['name'],
    //     //                 'parent_id' => $main->id,
    //     //                 'pers' => @$sub['pers']
    //     //             ]);
    //     //         }
    //     //     }
    //     // }

    //     // $partner->users()->create([
    //     //     'username' => 'owner',
    //     //     'full_name' => 'Owner',
    //     //     'email' => 'owner@fpt.com',
    //     //     'email_verified_at' => now(),
    //     //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     // ]);
    // }
    public function run()
    {
        $totalRows = 1000000;
        $batchSize = 1;
        $remainingRows = $totalRows;

        // Create a new instance of ProgressBar
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output);

        // Start the progress bar
        $progressBar->start($totalRows);

        while ($remainingRows > 0) {
            $rowsToCreate = min($batchSize, $remainingRows);
            \App\Models\MT\Message::factory()->count($rowsToCreate)->create();

            // Update the progress bar
            $progressBar->advance($rowsToCreate);

            $remainingRows -= $rowsToCreate;
        }

        // Finish the progress bar
        $progressBar->finish();
    }
}

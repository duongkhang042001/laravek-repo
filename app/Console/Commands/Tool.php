<?php

namespace App\Console\Commands;

use App\Imports\MessagesImport;
use App\Jobs\Brandname\Campaign\ImportMessages;
use App\Models\Brandname\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Tool extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tool';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaign = Campaign::find(200);
        // dd($campaign);
        // dd($campaign->file_import->path);
        dispatch(new \App\Jobs\Brandname\Report\Campaign(3615, 1));
        // Excel::import(new MessagesImport($campaign), $campaign->file_import->path);

        // $this->processPartners();

        // $this->processBrandnames();

        $this->processUsersHasBrandnames();

        // $this->processAccounts();

        // $this->processCampaigns();



        exit(1);
    }

    function processPartnersPermissions()
    {
        DB::table('v3_partners')->orderBy('id', 'desc')->chunk(500, function ($partners) {
        });
    }

    function processUsersHasBrandnames()
    {
        DB::table('v3_partners')->orderBy('id', 'desc')->chunk(500, function ($partners) {
            foreach ($partners as $partner) {
                $brandnames = DB::table('v3_brandnames')->where('partner_id', $partner->id)->get();

                $entries = [];
                DB::table('v3_users')->where('partner_id', $partner->id)->orderBy('id')->chunk(100, function ($users) use ($brandnames, &$entries) {
                    foreach ($users as $user) {
                        $entries += collect($brandnames)->map(function ($entry) use ($user) {
                            return [
                                'brandname_id' => $entry->id,
                                'user_id' => $user->id
                            ];
                        })->toArray();
                    }
                });
                DB::table('v3_user_has_brandnames')->insertOrIgnore($entries);
            }
        });
    }

    function processBrandnames()
    {
        $vendors = \App\Models\Core\Vendor::get();

        DB::connection('v3_mysql')->table('brandname_service')->orderBy('Id')->chunk(500, function ($brandnames) use ($vendors) {
            $entries = collect($brandnames)->map(function ($entry) use ($vendors) {
                return [
                    'id' => $entry->Id,
                    'partner_id' => $entry->PartnerId,
                    'vendor_id' => @collect($vendors)->where('name', $entry->Vendor)->first()->id,
                    'name' => $entry->Brandname,
                    'enabled' => $entry->Status,
                    'created_at' => $entry->CreatedTime,
                    'updated_at' => $entry->UpdatedTime
                ];
            })->toArray();

            DB::table('v3_brandnames')->insertOrIgnore($entries);
        });
    }

    function processPartners()
    {
        DB::table('partner')->orderBy('PartnerId')->chunk(1000, function ($partners) {

            $entries = collect($partners)->map(function ($entry) {
                return [
                    'id' => $entry->PartnerId,
                    'name' => $entry->Name,
                    'enabled' => 1,
                    'created_at' => $entry->CreatedTime,
                    'updated_at' => $entry->CreatedTime
                ];
            })->toArray();

            \App\Models\Core\Partner::insertOrIgnore($entries);
        });
    }

    function processAccounts()
    {
        DB::table('account')->orderBy('AccountId')->chunk(1000, function ($users) {

            $entries = collect($users)->map(function ($entry) {
                return [
                    'id' => $entry->AccountId,
                    'partner_id' => $entry->PartnerId,
                    'username' => $entry->UserName,
                    'full_name' => $entry->Fullname,
                    'phone_number' => $entry->PhoneOtp,
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                    'enabled' => 1,
                    'deleted_at' => null,
                    'created_at' => $entry->CreatedDate,
                    'updated_at' => $entry->UpdatedDate
                ];
            })->toArray();

            \App\Models\Auth\User::insertOrIgnore($entries);
        });
    }

    function processCampaigns()
    {
        $status = [
            'new' => 1,
            'pending' => 3,
            'sending' => 4,
            'sent' => 5,
            'cancel' => 6
        ];

        DB::connection('v3_mysql')->table('brandname_campaign')->orderBy('CampaignId')->chunk(1000, function ($campaigns) use ($status) {
            $entries = collect($campaigns)->map(function ($entry) use ($status) {
                return [
                    'id' => $entry->CampaignId,
                    'partner_id' => $entry->PartnerId,
                    'brandname_id' => $entry->BrandNameServiceId,
                    'code' => $entry->CampaignCode,
                    'title' => $entry->CampaignName,
                    'status' => $status[$entry->Status],
                    'approved_at' => $entry->CreatedDate,
                    'approved_by' => null,
                    'scheduled_at' => $entry->ScheduleTime,
                    'created_at' => $entry->CreatedDate,
                    'updated_at' => $entry->UpdatedDate
                ];
            })->toArray();

            DB::table('v3_campaigns')->insertOrIgnore($entries);
        });
    }

    function buildMenus($nodes = [], $permissions, $parentId = null)
    {
        $menus = [];

        foreach ($nodes as $node) {
            if ($node->parent_id === $parentId) {
                if (!is_null($node->permission_id) && !$permissions->firstWhere('id', $node->permission_id)) {

                    continue;
                }

                $menus[$node->id]['name'] = $node->name;

                $children = $this->buildMenus($nodes, $permissions, $node->id);

                $menus[$node->id]['sub'] = $children;
            }
        }

        return $menus;
    }
}

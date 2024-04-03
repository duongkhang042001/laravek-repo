<?php

namespace App;

use App\Models\Auth\User;
use App\Repositories\Core\SettingRepository;

class Core
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * 
     * @return User
     */
    public function currentUser()
    {
        return auth()->user();
    }

    public function setting()
    {
        return $this->settingRepository->all($this->currentUser()->partner_id);
    }

    public function parseOrder($order)
    {
        $orders = [
            'ascend' => 'asc',
            'descend' => 'desc'
        ];

        return $orders[$order] ?? 'desc';
    }

    public function genCampaignCode($partnerId)
    {
        return uniqid(str_replace('=', 'a', base64_encode($partnerId)));
    }
}

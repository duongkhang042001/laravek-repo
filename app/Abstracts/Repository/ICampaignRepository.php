<?php

namespace App\Abstracts\Repository;

interface ICampaignRepository
{
    function model();

    public function cancel($id);

    public function approve($id);

    public function confirm($id);
}

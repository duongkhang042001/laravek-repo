<?php

namespace App\Listeners;


use App\Enums\Telco;
use App\Enums\Provider;
use libphonenumber\PhoneNumberUtil;
use App\Models\Brandname\BrandnameConfig;
use App\Events\BrandnameConfigCreateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;



class BrandnameConfigListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;

    /**
     * Handle the event.
     */
    public function handle(BrandnameConfigCreateEvent $event): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $providerRecords = [];

        $model = $event->model;

        $defaults = $event->default;

        foreach ($defaults as $telco => $telcoDatas) {
            foreach ($telcoDatas as $providRecords => $providRecord) {
                $providerRecord = new BrandnameConfig([
                    'brandname_id' => $model->id,
                    'provider' => Provider::from($providRecords)->value,
                    'telco' => Telco::from($telco)->value,
                    'region_code' => $providRecord["region_code"],
                    'country_code' => $phoneUtil->getCountryCodeForRegion($providRecord["region_code"]),
                    'is_unicode' => $providRecord["is_unicode"],
                    'is_encrypted' => $providRecord["is_encrypted"]
                ]);
                $providerRecords[] = $providerRecord;
            }
        }
        $model->configs()->saveMany($providerRecords);
    }
}

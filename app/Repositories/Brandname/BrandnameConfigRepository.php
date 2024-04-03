<?php

namespace App\Repositories\Brandname;

use App\Enums\Telco;
use App\Enums\SMSType;
use App\Enums\Provider;
use Illuminate\Support\Facades\DB;
use App\Models\Brandname\Brandname;
use libphonenumber\PhoneNumberUtil;
use App\Abstracts\Repository\BaseRepository;
use App\Models\Brandname\BrandnameConfig as Model;
use Illuminate\Container\Container as Application;
use App\Abstracts\Repository\IBrandnameConfigRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class BrandnameConfigRepository extends BaseRepository implements IBrandnameConfigRepository
{
    function model()
    {
        return Model::class;
    }

    protected $brandnamePricingRepository;

    public function __construct(
        Application $app,
        CacheRepository $cache,
        BrandnamePricingRepository $brandnamePricingRepository,

    ) {
        parent::__construct($app, $cache);

        $this->brandnamePricingRepository = $brandnamePricingRepository;
    }

    public function getDefaults()
    {
        $telcoRecords = [];
        $regionCode = 'VN';

        foreach (Telco::toArray() as $telco) {
            foreach (Provider::toArray() as $provider) {
                $telcoRecords[Telco::from($telco)->label][$provider] = [
                    'region_code' => $regionCode,
                    'is_unicode' => false,
                    'is_encrypted' => false,
                    'pricings' => [],
                ];
            }
        }

        return $telcoRecords;
    }

    public function all($brandnameId = null)
    {
        Brandname::findOrFail($brandnameId);

        $items = $this->model->where("brandname_id", $brandnameId)->get()->toArray();

        $pricings = $this->model->where("brandname_id", $brandnameId)->first()->brandname->pricings->toArray();

        $theDefault = $this->getDefaults();

        foreach ($items as $item) {

            $telcoLabel = Telco::from($item['telco'])->label;
            $providerLabel = Provider::from($item['provider'])->label;

            $providerData = [
                "region_code" => $item['region_code'],
                "is_unicode" => $item['is_unicode'],
                "is_encrypted" => $item['is_encrypted'],
                "pricings" => [],
            ];
            $theDefault[$telcoLabel][$providerLabel] = $providerData;

            foreach ($pricings as $pricing) {
                if ($pricing["telco"] === $item['telco'] && $pricing["provider"] === $item['provider']) {
                    $smsTypeLabel = SMSType::from($pricing["sms_type"])->label;

                    $pricingsData = [
                        "from_sms_qty" => $pricing['from_sms_qty'],
                        "to_sms_qty" => $pricing['to_sms_qty'],
                        "price_per_sms" => $pricing['price_per_sms'],
                        "cost_per_sms" => $pricing['cost_per_sms'],
                    ];

                    $theDefault[$telcoLabel][$providerLabel]['pricings'][$smsTypeLabel][] = $pricingsData;
                }
            }
        }
        return collect($theDefault);
    }

    public function create($attributes)
    {
        //
    }

    public function find($id)
    {
        //
    }

    public function update($id, $attributes)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function bulkUpdate(array $inputs = [], $brandnameId)
    {
        Brandname::findOrFail($brandnameId);

        if (empty($inputs)) {
            return;
        }

        $originalData = collect($this->all($brandnameId));
        $mergedData = $originalData->merge($inputs);

        $phoneUtil = PhoneNumberUtil::getInstance();
        $pricingsArray = [];
        $configArray = [];

        foreach ($mergedData as $telco => $providers) {
            foreach ($providers as $providersData => $providerData) {
                $providerConfig = [];

                if (Provider::tryFrom($providersData) == NULL) {
                    continue;
                }

                if (Telco::tryFrom($telco) == NULL) {
                    continue;
                }

                $providerConfig['brandname_id'] = $brandnameId;
                $providerConfig['provider'] = Provider::from($providersData)->value;
                $providerConfig['telco'] = Telco::from($telco)->value;
                $providerConfig['region_code'] = $providerData['region_code'];
                $providerConfig['country_code'] = $phoneUtil->getCountryCodeForRegion($providerData["region_code"]);
                $providerConfig['is_unicode'] = $providerData['is_unicode'];
                $providerConfig['is_encrypted'] = $providerData['is_encrypted'];

                $configArray[] = $providerConfig;

                $pricings = $providerData["pricings"];

                foreach ($pricings as $sms_type => $pricingData) {
                    foreach ($pricingData as $pricing) {

                        if (SMSType::tryFrom($sms_type) == NULL) {
                            continue;
                        }

                        $providerPricing = [
                            'brandname_id' => $brandnameId,
                            'provider' => Provider::from($providersData)->value,
                            'telco' => Telco::from($telco)->value,
                            'sms_type' => SMSType::from($sms_type)->value,
                            'region_code' => $providerData['region_code'],
                            'country_code' => $phoneUtil->getCountryCodeForRegion($providerData['region_code']),
                            'from_sms_qty' => $pricing['from_sms_qty'],
                            'to_sms_qty' => $pricing['to_sms_qty'],
                            'cost_per_sms' => $pricing['cost_per_sms'],
                            'price_per_sms' => $pricing['price_per_sms'],
                        ];
                        $pricingsArray[] = $providerPricing;
                    }
                }
            }
        }
        if ($configArray == []) {
            return $this->all($brandnameId);
        }
        DB::transaction(function () use ($brandnameId, $configArray, $pricingsArray) {
            $model = $this->model->where("brandname_id", $brandnameId)->first();
            $model->brandname->configs()->delete();
            $model->brandname->configs()->insert($configArray);
            $model->brandname->pricings()->insert($pricingsArray);
        });
        return $this->all($brandnameId);
    }
}

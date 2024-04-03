<?php

namespace App\Repositories\Core;

use App\Models\Core\Partner;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Setting as Model;
use App\Abstracts\Repository\BaseRepository;

class SettingRepository extends BaseRepository
{
    function model()
    {
        return Model::class;
    }

    private function getDefaults()
    {
        return [
            'authenticate.enabled2FA' => 'no',
            'campaign.autoApproval' => 'yes',
        ];
    }

    public function all($partnerId = null)
    {
        Partner::findOrFail($partnerId);

        $values = $this->cache->rememberForever("{$partnerId}_getSettings", function () use ($partnerId) {
            return $this->model->select('value', 'key')->where('partner_id', $partnerId)->pluck('value', 'key');
        });

        return collect($this->getDefaults())->merge($values);
    }


    public function bulkUpdate(array $inputs = [], $partnerId = null)
    {
        Partner::findOrFail($partnerId);

        if (empty($inputs)) {
            return;
        }

        $defaults = $this->getDefaults();

        $settings = collect($this->all())
            ->merge($inputs)
            ->filter(function ($v, $k) use ($defaults) {
                return isset($defaults[$k]);
            })
            ->map(function ($value, $key) use ($partnerId) {
                return [
                    'partner_id'   => $partnerId,
                    'key'       => $key,
                    'value'     => $value
                ];
            })
            ->flatMap(function ($values) {
                return [$values];
            })
            ->all();

        DB::transaction(function () use ($partnerId, $settings) {
            $this->model->where('partner_id', $partnerId)->delete();

            $this->model->insert($settings);
        });

        $this->cache->forget("{$partnerId}_getSettings");

        return $this->all($partnerId);
    }

    public function create($attributes)
    {
        // Implementation for the create method
    }

    public function find($id)
    {
        // Implementation for the find method
    }

    public function update($id, $attributes)
    {
        // Implementation for the update method
    }

    public function delete($id)
    {
        // Implementation for the find method
    }
}

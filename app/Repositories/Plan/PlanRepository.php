<?php

namespace App\Repositories\Plan;

use App\Models\Plan\Volume;
use App\Models\Plan\Plan as Model;
use App\Abstracts\Repository\BaseRepository;
use App\Abstracts\Repository\IPlanRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class PlanRepository extends BaseRepository implements IPlanRepository
{
    protected $cache;
    protected $cacheKeyPrefix = 'plan';

    protected $minute = 900;

    function model()
    {
        return Model::class;
    }
    public function __construct(
        Application $app,
        CacheRepository $cache,
    ) {
        parent::__construct($app, $cache);
    }

    public function all($filter = [])
    {
        $cacheKey = $this->buildCacheKey($filter);

        return $this->cache->remember(
            $cacheKey,
            $this->minute,
            function () use ($filter) {
                $perPage = isset($filter['limit']) && !empty($filter['limit']) ? $filter['limit'] : 5;

                $qb = $this->model->select(['v3_plans.*']);

                $from = isset($filter['from']) ? $filter['from'] : date('Y-m-d', strtotime('-90 days'));
                $to = isset($filter['to']) ? date('Y-m-d', strtotime($filter['to'] . ' +1 day')) : date('Y-m-d', strtotime('+1 days'));

                $qb->where(function ($q) use ($from, $to) {
                    $q->where('created_at', '>=', $from)->where('created_at', '<', $to);
                });

                if (!empty($filter['partner_id'])) {
                    $qb->where('partner_id', $filter['partner_id']);
                }

                if (!empty($filter['provider'])) {
                    $qb->where('provider', $filter['provider']);
                }

                if (!empty($filter['telcos'])) {
                    $qb->whereIn('telco', explode(',', $filter['telcos']));
                }

                if (!empty($filter['sms_type'])) {
                    $qb->where('sms_type', $filter['sms_type']);
                }

                if (!empty($filter['region_code'])) {
                    $qb->where('region_code', $filter['region_code']);
                }

                $qb->orderBy('created_at', 'desc');

                $results = $qb->with('volumes')->cursorPaginate($perPage);

                $this->resetModel();

                return $results;
            }
        );
    }

    public function find($id)
    {
        $cacheKey = $this->getCacheKey($id);

        return $this->cache->remember(
            $cacheKey,
            $this->minute,
            function () use ($id) {

                $model = $this->model->with('volumes')->findOrFail($id);

                $this->resetModel();

                return $model;
            }
        );
    }

    public function update($attributes, $id)
    {
        $plan = $this->model->findOrFail($id);
        if (!$plan) {
            throw new ModelNotFoundException("Plan with id {$id} not found.");
        }

        if (isset($data['partner_id'])) {
            $plan->partner_id = $attributes['partner_id'];
        }

        if (isset($data['sms_usage_count'])) {
            $plan->partner_id = $attributes['sms_usage_count'];
        }

        $plan->save();

        if (isset($attributes['volume_pricings'])) {
            foreach ($attributes['volume_pricings'] as $volumeData) {
                $volume = Volume::find($volumeData['id']);
                if (!$volume) {
                    throw new ModelNotFoundException("Volume with id {$volumeData['id']} not found.");
                }
                if (isset($volumeData['min_qty'])) {
                    $volume->min_qty = $volumeData['min_qty'];
                }
                if (isset($attributes['max_qty'])) {
                    $volume->max_qty = $volumeData['min_qty'];
                }
                if (isset($attributes['price_per_unit'])) {
                    $volume->price_per_unit = $volumeData['min_qty'];
                }
                $volume->save();
            }
        }

        $this->resetModel();

        $this->cache->forget($this->getCacheKey($id));

        $this->clearAllCache();

        return $plan;
    }

    public function delete($id)
    {
        //
    }

    public function create($attributes)
    {
        //
    }

    protected function getCacheKey($id)
    {
        return "{$this->cacheKeyPrefix}:{$id}";
    }

    protected function buildCacheKey($filter)
    {
        $partnerId = $filter['partner_id'] ?? 'null';
        $telco = $filter['telco'] ?? 'null';
        $smsType = $filter['sms_type'] ?? 'null';
        $regionCode = $filter['region_code'] ?? 'null';

        return "{$this->cacheKeyPrefix}:{$partnerId}-{$telco}-{$smsType}-{$regionCode}";
    }
    protected function clearAllCache()
    {
        $this->cache->forget($this->buildCacheKey([]));
    }
}

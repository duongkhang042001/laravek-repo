<?php

namespace App\Repositories\Brandname;

use Illuminate\Support\Str;
use App\Models\Brandname\Message as Model;
use App\Abstracts\Repository\BaseRepository;
use App\Abstracts\Repository\IMessageRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class MessageRepository extends BaseRepository implements IMessageRepository
{

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
        $perPage = isset($filter['limit']) && !empty($filter['limit']) ? $filter['limit'] : 5;

        $qb = $this->model->select(['v3_messages.*']);

        $from = isset($filter['from']) ? $filter['from'] : date('Y-m-d', strtotime('-90 days'));
        $to = isset($filter['to']) ? date('Y-m-d', strtotime($filter['to'] . ' +1 day')) : date('Y-m-d', strtotime('+1 days'));

        $qb->where(function ($q) use ($from, $to) {
            $q->where('delivered_at', '>=', $from)->where('delivered_at', '<', $to);
        });

        if (!empty($filter['brandname_id'])) {
            $qb->where('brandname_id', $filter['brandname_id']);
        }

        if (!empty($filter['campaign_id'])) {
            $qb->where('campaign_id', $filter['campaign_id']);
        }

        if (!empty($filter['telcos'])) {
            $qb->whereIn('telco', explode(',', $filter['telcos']));
        }

        if (!empty($filter['sms_type'])) {
            $qb->where('sms_type', $filter['sms_type']);
        }

        if (!empty($filter['recipent'])) {
            $recipent = Str::replaceFirst('0', '84', $filter['recipent']);

            $qb->where('recipent', 'LIKE', $recipent . '%');
        }

        if (isset($filter['status'])) {
            switch ($filter['status']) {
                case 1: // chưa gửi
                    $qb->where('is_delivered', 0);
                    break;
                case 2: // đã gửi
                    $qb->where('is_delivered', 1);
                    break;
                case 3: // thành công
                    $qb->where('is_sent', 1); // error = 0 => error != 0
                    break;
                case 4: // thất bại
                    $qb->where('error', '>', 0);
                    break;
                default:
                    // Handle any other cases if needed
                    break;
            }
        }

        $qb->orderBy('delivered_at', 'desc');

        $results = $qb->with('campaign')->cursorPaginate($perPage);

        $this->resetModel();

        return $results;
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

    public function export($filter, $title)
    {
        //
    }
}

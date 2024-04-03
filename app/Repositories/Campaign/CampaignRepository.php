<?php

namespace App\Repositories\Campaign;

use Carbon\Carbon;
use App\Enums\SMSType;
use App\Enums\CampaignStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Campaign\Campaign as Model;
use App\Abstracts\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Abstracts\Repository\ICampaignRepository;

class CampaignRepository extends BaseRepository implements ICampaignRepository
{

    function model()
    {
        return Model::class;
    }

    public function all($filter = [])
    {
        $perPage = isset($filter['pageSize']) && !empty($filter['pageSize']) ? $filter['pageSize'] : 9;

        $page = Paginator::resolveCurrentPage('current');

        $qb = $this->model->select(['v3_campaigns.*']);

        if (isset($filter['from']) && isset($filter['to'])) {
            $qb->where(function ($q) use ($filter) {
                $q->where('created_at', '>=', date('Y-m-d', strtotime($filter['from'])))
                    ->where('created_at', '<', date('Y-m-d', strtotime($filter['to'] . ' +1 day')));
            });
        }

        if (!empty($filter['title'])) {
            $qb->where('title', 'like', $filter['title'] . '%');
        }

        if (!empty($filter['status'])) {
            $status = CampaignStatus::tryFrom($filter['status']);
            if (!is_null($status)) {
                $qb->where('status', $status->value);
            }
        }

        $defaultSortField = isset($filter['sort']) ? $filter['sort'] :  'created_at';
        $defaultSortOrder = isset($filter['order']) ? $filter['order'] :  'descend';

        $qb->orderBy($defaultSortField, core()->parseOrder($defaultSortOrder));

        $countQuery = "select count(*) as aggregate from ({$qb->toSql()}) c";
        $count = collect(DB::select($countQuery, $qb->getBindings()))->pluck('aggregate')->first();

        if ($count > 0) {
            $items = $qb->forPage($page, $perPage)->with(['brandname:id,name'])->get();
        } else {
            $items = [];
        }

        $results = new LengthAwarePaginator($items, $count, $perPage, $page, [
            'path'  => request()->url(),
            'query' => request()->query(),
        ]);

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

    public function cancel($id)
    {
        //
    }

    public function approve($id)
    {
        //
    }

    public function confirm($id)
    {
        $model = $this->model->findOrFail($id);

        $this->resetModel();

        if ($model->confirmed_at != NULL) {
            abort(409, 'Campaign has already been confirmed');
        }

        if (SMSType::from($model->sms_type)->equals(SMSType::qc())) {
            $confirmed = $model->update([
                'confirmed_at' => Carbon::now()->format('Y-m-d H:i'),
            ]);
        }

        $this->resetModel();

        return $confirmed;
    }
}

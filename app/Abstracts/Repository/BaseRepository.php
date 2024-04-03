<?php

namespace App\Abstracts\Repository;

use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IRepository
{
    protected $app;

    protected $cache;

    protected $model;

    public function __construct(Application $app, CacheRepository $cacheRepository)
    {
        $this->app = $app;
        $this->cache = $cacheRepository;
        $this->makeModel();
    }

    function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    function resetModel()
    {
        $this->makeModel();
    }
}

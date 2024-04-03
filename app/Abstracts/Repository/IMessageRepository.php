<?php

namespace App\Abstracts\Repository;

interface IMessageRepository
{
    function model();

    public function export($filter, $title);
}

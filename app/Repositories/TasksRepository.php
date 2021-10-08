<?php

namespace App\Repositories;

use App\Models\Collections\TasksCollection;
use App\Models\Record;

interface TasksRepository
{
    public function fetchAllRecords(): TasksCollection;

    public function save(Record $record): void;

    public function getOne(string $id): ?Record;

    public function delete(Record $record): void;
}
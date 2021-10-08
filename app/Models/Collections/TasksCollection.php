<?php

namespace App\Models\Collections;

use App\Models\Record;

class TasksCollection
{
    private array $listOfTasks = [];

    public function __construct(array $tasks = [])
    {
        foreach ($tasks as $task) $this->add($task);
    }

    public function add(Record $record): void
    {
        $this->listOfTasks[$record->getId()] = $record;
    }

    public function remove(Record $record): void
    {
        unset($this->listOfTasks[$record->getId()]);
    }

    public function getListOfTasks(): array
    {
        return $this->listOfTasks;
    }
}
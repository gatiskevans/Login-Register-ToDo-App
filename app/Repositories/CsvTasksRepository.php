<?php

namespace App\Repositories;

use App\Models\Collections\TasksCollection;
use App\Models\Record;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvTasksRepository implements TasksRepository
{
    private Reader $tasks;
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;

        if (!file_exists($path)) Writer::createFromPath($this->path, 'w');
        $this->tasks = Reader::createFromPath($path);
    }

    public function save(Record $record): void
    {
        $writer = Writer::createFromPath($this->path, 'a');
        $writer->insertOne($record->toArray());
    }

    public function fetchAllRecords(): TasksCollection
    {
        $tasksCollection = new TasksCollection();

        $sorting = Statement::create()->orderBy(
            function (array $a, array $b) {
                $timeA = new Carbon($a[3]);
                $timeB = new Carbon($b[3]);

                return $timeA->lessThan($timeB) ? 1 : -1;
            }
        );

        foreach ($sorting->process($this->tasks) as $record) {
            $tasksCollection->add(new Record(
                $record[0],
                $record[1],
                $record[2],
                $record[3]
            ));
        }

        return $tasksCollection;
    }

    public function getOne(string $id): ?Record
    {
        $statement = Statement::create()->where(
            function ($record) use ($id) {
                return $record[0] === $id;
            }
        );

        $record = $statement->process($this->tasks)->fetchOne();

        if (empty($record)) return null;

        return new Record(
            $record[0],
            $record[1],
            $record[2],
            $record[3]
        );
    }

    public function delete(Record $record): void
    {
        $allTasks = $this->fetchAllRecords();
        $allTasks->remove($record);
        $records = [];

        foreach ($allTasks->getListOfTasks() as $task) {
            /** @var Record $task */
            $records[] = $task->toArray();
        }

        $writer = Writer::createFromPath($this->path, 'w');
        $writer->insertAll($records);
    }
}
<?php

namespace App\Repositories;

use App\Models\Collections\TasksCollection;
use App\Models\Record;

class MySQLTasksRepository extends MySQLConnect implements TasksRepository
{

    public function fetchAllRecords(): TasksCollection
    {
        $tasksCollection = new TasksCollection();

        $sql = "SELECT * FROM tasks ORDER BY created DESC";
        $statement = $this->connect()->query($sql);

        foreach ($statement->fetchAll() as $row) {
            $tasksCollection->add(new Record(
                $row['id'],
                $row['task'],
                $row['status'],
                $row['created']
            ));
        }
        return $tasksCollection;
    }

    public function save(Record $record): void
    {
        $sql = "INSERT INTO tasks (task, status, created) VALUES (:task, :status, :created)";

        $statement = $this->connect()->prepare($sql);

        $statement->execute([
            ':task' => $record->getTask(),
            ':status' => $record->getStatus(),
            ':created' => $record->getTimeCreated()
        ]);
    }

    public function getOne(string $id): ?Record
    {
        $statement = $this->connect()->query("SELECT * FROM tasks WHERE id={$id}")->fetch();
        return new Record(
            $statement['id'],
            $statement['task'],
            $statement['status'],
            $statement['created']
        );
    }

    public function delete(Record $record): void
    {
        $this->connect()->prepare("DELETE FROM tasks WHERE id=?")->execute([$record->getId()]);
    }
}
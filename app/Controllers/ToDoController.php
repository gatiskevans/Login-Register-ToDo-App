<?php

namespace App\Controllers;

use App\Models\Record;
use App\Repositories\CsvTasksRepository;
use App\Repositories\MySQLTasksRepository;
use App\Repositories\TasksRepository;
use Ramsey\Uuid\Uuid;

class ToDoController
{
    private TasksRepository $tasksRepository;

    public function __construct()
    {
        //$this->tasksRepository = new CsvTasksRepository('Storage/CSV/Tasks.csv');
        $this->tasksRepository = new MySQLTasksRepository();
    }

    public function showTasks(): void
    {
        $tasks = $this->tasksRepository->fetchAllRecords();

        require_once 'app/Views/Tasks/show.view.php';
    }

    public function showAddTask(): void
    {
        require_once 'app/Views/Tasks/add.view.php';
    }

    public function addTask(): void
    {
        $record = new Record(
            Uuid::uuid4(),
            $_POST['task']
        );

        $this->tasksRepository->save($record);

        header('Location: /todo');
    }

    public function deleteTask(array $vars): void
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $task = $this->tasksRepository->getOne($id);
        if ($task != null) $this->tasksRepository->delete($task);
        header('Location: /');
    }
}
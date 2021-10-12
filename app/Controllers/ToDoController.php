<?php

namespace App\Controllers;

use App\Models\Record;
use App\Repositories\CsvTasksRepository;
use App\Repositories\MySQLTasksRepository;
use App\Repositories\TasksRepository;
use App\Validation\FormValidationException;
use App\Validation\TasksValidator;
use Ramsey\Uuid\Uuid;

class ToDoController
{
    private TasksRepository $tasksRepository;
    private TasksValidator $tasksValidator;

    public function __construct()
    {
        //$this->tasksRepository = new CsvTasksRepository('Storage/CSV/Tasks.csv');
        $this->tasksRepository = new MySQLTasksRepository();
        $this->tasksValidator = new TasksValidator();
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
        try{
            $this->tasksValidator->validate($_POST);

            $record = new Record(
                Uuid::uuid4(),
                $_POST['task']
            );

            $this->tasksRepository->save($record);

            header('Location: /todo');
        } catch(FormValidationException $exception)
        {
            $_SESSION['_errors'] = $this->tasksValidator->getErrors();
            header('Location: /add');
        }
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
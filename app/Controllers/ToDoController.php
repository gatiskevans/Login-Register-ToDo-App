<?php

namespace App\Controllers;

use App\Models\Record;
use App\Repositories\CsvTasksRepository;
use App\Repositories\MySQLTasksRepository;
use App\Repositories\TasksRepository;
use App\Validation\FormValidationException;
use App\Validation\TasksValidator;
use App\View;
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

    public function showTasks(): View
    {
        $tasks = $this->tasksRepository->fetchAllRecords();

        return new View('Tasks/showTasks.twig', ['tasks' => $tasks]);
    }

    public function showAddTask(): View
    {
        return new View('Tasks/add.twig');
    }

    public function showEdit(array $vars): View
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');
        $task = $this->tasksRepository->getOne($id);

        return new View('Tasks/edit.twig', ['task' => $task]);
    }

    public function editTask(array $vars): void
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $task = $this->tasksRepository->getOne($id);

        if ($task != null) $this->tasksRepository->edit($task, $_POST['task']);
        header('Location: /');
    }

    public function addTask(): void
    {
        try {
            $this->tasksValidator->validate($_POST);

            $record = new Record(
                Uuid::uuid4(),
                $_POST['task']
            );

            $this->tasksRepository->save($record);

            header('Location: /todo');
        } catch (FormValidationException $exception) {
            $_SESSION['_errors'] = $this->tasksValidator->getErrors();
            header('Location: /add');
            exit;
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
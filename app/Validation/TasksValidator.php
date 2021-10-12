<?php

namespace App\Validation;

class TasksValidator
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate(array $data): void
    {
        if(!isset($data['task']) || empty($data['task']))
        {
            $this->errors['task'] = "Task must be required";
        }

        if(count($this->errors) > 0) {
            throw new FormValidationException();
        }
    }
}
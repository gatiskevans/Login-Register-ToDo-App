<?php

namespace App\Models;

use Carbon\Carbon;

class Record
{
    private string $task;
    private string $id;
    private ?string $status = '';
    private ?string $timeCreated;

    public const STATUS_COMPLETED = 'completed';
    public const STATUS_IN_PROGRESS = 'in progress';

    private const STATUSES = [
        self::STATUS_COMPLETED,
        self::STATUS_IN_PROGRESS
    ];

    public function __construct(string $id, string $taskName, ?string $status = null, ?string $timeCreated = null)
    {
        $this->task = $taskName;
        $this->id = $id;
        $this->timeCreated = $timeCreated ?? Carbon::now();
        $this->setStatus($status ?? self::STATUS_IN_PROGRESS);
    }

    public function getTask(): string
    {
        return $this->task;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTimeCreated(): ?string
    {
        return $this->timeCreated;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'task' => $this->getTask(),
            'status' => $this->getStatus(),
            'created' => $this->getTimeCreated(),
        ];
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, self::STATUSES)) return;

        $this->status = self::STATUS_IN_PROGRESS;
    }
}
<?php

namespace App\Domain;

use DateTime;
use Illuminate\Support\Str;

class TaskEntity
{
    private string $id;
    private string $user_id;
    private string $category_id;
    private string $title;
    private string|null $description;
    private TaskStatusEnum|null $status;
    private DateTime|null $created_at;
    private DateTime|null $updated_at;

    public function __construct(
        string $user_id,
        string $category_id,
        string $title,
        ?string $description = null,
        ?string $id = null,
        ?TaskStatusEnum $status = null,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ) {
        $this->id = $id ?? Str::uuid();
        $this->user_id = $user_id;
        $this->category_id = $category_id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status ?? TaskStatusEnum::PENDING;
        $this->created_at = $created_at ?? new DateTime();
        $this->updated_at = $updated_at ?? new DateTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return TaskStatusEnum|null
     */
    public function getStatus(): ?TaskStatusEnum
    {
        return $this->status;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param string $category_id
     */
    public function setCategoryId(string $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param TaskStatusEnum|null $status
     */
    public function setStatus(?TaskStatusEnum $status): void
    {
        $this->status = $status;
    }

    /**
     * @param DateTime|null $created_at
     */
    public function setCreatedAt(?DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @param DateTime|null $updated_at
     */
    public function setUpdatedAt(?DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}

<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Progress::class, inversedBy="task_id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $progress_id;

    /**
     * @ORM\ManyToOne(targetEntity=Workspace::class, inversedBy="task_id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $workspace_id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $priority;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getProgressId(): ?Progress
    {
        return $this->progress_id;
    }

    public function setProgressId(?Progress $progress_id): self
    {
        $this->progress_id = $progress_id;

        return $this;
    }

    public function getWorkspaceId(): ?Workspace
    {
        return $this->workspace_id;
    }

    public function setWorkspaceId(?Workspace $workspace_id): self
    {
        $this->workspace_id = $workspace_id;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}

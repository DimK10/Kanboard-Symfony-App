<?php

namespace App\Entity;

use App\Repository\ProgressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgressRepository::class)
 */
class Progress
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
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="progress_id")
     */
    private $task_id;

    /**
     * @ORM\ManyToOne(targetEntity=Workspace::class, inversedBy="progress_id")
     */
    private $workspace_id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $color;

    /**
     * @ORM\Column(type="smallint")
     */
    private $priority;

    public function __construct()
    {
        $this->task_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTaskId(): Collection
    {
        return $this->task_id;
    }

    public function addTaskId(Task $taskId): self
    {
        if (!$this->task_id->contains($taskId)) {
            $this->task_id[] = $taskId;
            $taskId->setProgressId($this);
        }

        return $this;
    }

    public function removeTaskId(Task $taskId): self
    {
        if ($this->task_id->removeElement($taskId)) {
            // set the owning side to null (unless already changed)
            if ($taskId->getProgressId() === $this) {
                $taskId->setProgressId(null);
            }
        }

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

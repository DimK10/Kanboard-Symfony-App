<?php

namespace App\Entity;

use App\Repository\WorkspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkspaceRepository::class)
 */
class Workspace
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="workspace_id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="workspace_id")
     */
    private $task_id;

    /**
     * @ORM\OneToMany(targetEntity=Progress::class, mappedBy="workspace_id")
     */
    private $progress_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->task_id = new ArrayCollection();
        $this->progress_id = new ArrayCollection();
    }

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->addWorkspaceId($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->user_id->removeElement($userId)) {
            $userId->removeWorkspaceId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTaskId(): Collection
    {
        return $this->task_id;
    }

    public function addTaskId(?Task $taskId): self
    {
        if ($taskId != null && !$this->task_id->contains($taskId)) {
            $this->task_id[] = $taskId;
            $taskId->setWorkspaceId($this);
        }

        return $this;
    }

    public function removeTaskId(Task $taskId): self
    {
        if ($this->task_id->removeElement($taskId)) {
            // set the owning side to null (unless already changed)
            if ($taskId->getWorkspaceId() === $this) {
                $taskId->setWorkspaceId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Progress[]
     */
    public function getProgressId(): Collection
    {
        return $this->progress_id;
    }

    public function addProgressId(Progress $progressId): self
    {
        if (!$this->progress_id->contains($progressId)) {
            $this->progress_id[] = $progressId;
            $progressId->setWorkspaceId($this);
        }

        return $this;
    }

    public function removeProgressId(Progress $progressId): self
    {
        if ($this->progress_id->removeElement($progressId)) {
            // set the owning side to null (unless already changed)
            if ($progressId->getWorkspaceId() === $this) {
                $progressId->setWorkspaceId(null);
            }
        }

        return $this;
    }
}

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
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="workspaces")
     * @ORM\JoinColumn(nullable=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="workspace")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=Progress::class, mappedBy="workspace", cascade="persist", fetch="EAGER")
     */
    private $progresses;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->progresses = new ArrayCollection();
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
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->users->contains($userId)) {
            $this->users[] = $userId;
            $userId->addWorkspaceId($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->users->removeElement($userId)) {
            $userId->removeWorkspaceId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTaskId(?Task $taskId): self
    {
        if ($taskId != null && !$this->tasks->contains($taskId)) {
            $this->tasks[] = $taskId;
            $taskId->setWorkspace($this);
        }

        return $this;
    }

    public function removeTaskId(Task $taskId): self
    {
        if ($this->tasks->removeElement($taskId)) {
            // set the owning side to null (unless already changed)
            if ($taskId->getWorkspace() === $this) {
                $taskId->setWorkspace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Progress[]
     */
    public function getProgresses(): Collection
    {
        return $this->progresses;
    }

    public function setProgresses(array $progresses) {
        $this->progresses = $progresses;
    }

    public function addProgressId(Progress $progressId): self
    {
        if (!$this->progresses->contains($progressId)) {
            $this->progresses[] = $progressId;
            $progressId->setWorkspace($this);
        }

        return $this;
    }

    public function removeProgressId(Progress $progressId): self
    {
        if ($this->progresses->removeElement($progressId)) {
            // set the owning side to null (unless already changed)
            if ($progressId->getWorkspace() === $this) {
                $progressId->setWorkspace(null);
            }
        }

        return $this;
    }
}

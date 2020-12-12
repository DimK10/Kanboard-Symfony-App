<?php


namespace App\Service;


use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{

    private $entityManager;
    private $taskRepository;

    /**
     * ProgressService constructor.
     * @param $taskRepository
     */
    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $entityManager)
    {
        $this->taskRepository = $taskRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Task
     */
    public function findLastTaskWithTheLeastPriority()
    {
        return $this->taskRepository->findLastTaskWithTheLeastPriority();
    }

    public function persist(Task $task) {
        $this->entityManager->persist($task);
    }
}
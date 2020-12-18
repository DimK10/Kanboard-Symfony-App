<?php


namespace App\Service;


use App\Entity\Progress;
use App\Entity\Task;
use App\Entity\Workspace;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

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
        $this->entityManager->flush();

        return $task->getId();
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function deleteTask(int $id): ?object
    {

        try {
            $taskTodelete = $this->entityManager->getReference(Task::class, $id);
            $this->entityManager->remove($taskTodelete);
            $this->entityManager->flush();
            return $taskTodelete;
        } catch (ORMException $e) {
            dump($e);

        }
        return null;
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function updateTask(int $id, $updatedTask): ?object
    {

        try {
            /** @var Task $taskToUpdate */
            $taskToUpdate = $this->entityManager->find(Task::class, $id);

            /** @var Task $updatedTask */
            $taskToUpdate->setName($updatedTask->getName());
            $taskToUpdate->setDescription($updatedTask->getDescription());
            $taskToUpdate->setColor($updatedTask->getColor());
            $taskToUpdate->setProgress($updatedTask->getProgress());
            $taskToUpdate->setWorkspace($updatedTask->getWorkspace());
            $taskToUpdate->setPriority($updatedTask->getPriority());


            $this->entityManager->persist($taskToUpdate); // Not really needed for managed entities - Doctrine already knows that when flushing, its for and update operation
            $this->entityManager->flush();
            return $taskToUpdate;
        } catch (ORMException $e) {
            dump($e);

        }
        return null;
    }

    public function getProgressProxyForASpecificTask($progressId): ?object
    {
        try {
            return $this->entityManager->getReference(Progress::class, $progressId);
        } catch (ORMException $e) {
            dump($e);
        }
    }

    public function getWorkspaceProxyFromAspecificTask($workspaceId): ?object {
        try {
            return $this->entityManager->getReference(Workspace::class, $workspaceId);
        } catch (ORMException $e) {
            dump($e);
        }
    }

    private function findAllTasksWithoutTaskThatWasMoved(int $taskId, int $fromProgressId) {
        return $this->taskRepository->findAllTasksWithoutTaskThatWasMoved($taskId, $fromProgressId);
    }

    private function findAllTasksThatHaveGreaterOrEqualPriority(int $taskId, int $priorityNum, int $fromProgressId): array
    {
        return $this->taskRepository->findAllTasksThatPriorityIsGeaterThanTheNumGiven($taskId, $priorityNum, $fromProgressId);
    }

    public function updatePrioritiesOfTasksOnPreviousProgressAndNextProgress(int $taskId, string $changedColor, int $fromProgressId, int $priorityNumFromProgress, int $toProgressId, int $priorityNumToProgress)
    {
       if ($fromProgressId != $toProgressId) {
           $tasksBefore = $this->findAllTasksWithoutTaskThatWasMoved($taskId, $fromProgressId);

           $tasksAfter = $this->findAllTasksThatHaveGreaterOrEqualPriority($taskId, $priorityNumToProgress, $toProgressId);


           for ($i = 0; $i < count($tasksBefore);  $i++) {
               $tasksBefore[$i]->setPriority($i + 1);
           }

           foreach ($tasksAfter as $task) {
               $task->setPriority($task->getPriority() + 1);
           }
       } else {
           // only need to update once because the card task in ui is on the same column
           $tasksAfter = $this->findAllTasksThatHaveGreaterOrEqualPriority($taskId, $priorityNumToProgress, $toProgressId);

           foreach ($tasksAfter as $task) {
               $task->setPriority($task->getPriority() +1);
           }
       }

       // Set the new color and the new Priority num to the task which it was drag dropped
        $task = $this->entityManager->find(Task::class, $taskId);
       $progress = $this->entityManager->find(Progress::class, $toProgressId);
        $task->setColor($changedColor);
        $task->setProgress($progress);
        $task->setPriority($priorityNumToProgress);

        $this->entityManager->flush();
    }
}
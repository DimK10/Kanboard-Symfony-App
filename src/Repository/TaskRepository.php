<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

     /**
      * @return Task Returns a Task object
      */

    public function findLastTaskWithTheLeastPriority()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.priority', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $taskId
     * @param int $progressId
     * @return Task[] Returns an array of Task objects
     */

    public function findAllTasksWithoutTaskThatWasMoved(int $taskId, int $progressId): array
    {
        return $this->createQueryBuilder('t')
            ->setParameter(":taskId", $taskId)
            ->setParameter(":progressId", $progressId)
            ->andWhere("t.progress = :progressId")
            ->andWhere("t.id != :taskId")
            ->orderBy("t.priority", "ASC")
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $taskId
     * @param int $progressId
     * @return Task[] Returns an array of Task objects
     */

    public function findAllTasksWithoutTaskThatWasMovedAndWithoutFirstTask(int $taskId, int $progressId): array
    {
        return $this->createQueryBuilder('t')
            ->setParameter(":taskId", $taskId)
            ->setParameter(":progressId", $progressId)
            ->andWhere("t.progress = :progressId")
            ->andWhere("t.id != :taskId")
            ->andWhere("t.id != 1") //FIXME Does this work on each use case? Or is it a blunder?
            ->orderBy("t.priority", "ASC")
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $taskId
     * @param int $priorityNum
     * @param int $progressId
     * @return Task[] Returns an array of Task objects
     */

    public function findAllTasksThatPriorityIsGeaterThanTheNumGiven(int $taskId, int $priorityNum, int $progressId): array
    {
        return $this->createQueryBuilder('t')
            ->setParameter(":taskId", $taskId)
            ->setParameter(":priorityNum", $priorityNum)
            ->setParameter(":progressId", $progressId)
            ->andWhere("t.priority >= :priorityNum")
            ->andWhere("t.progress = :progressId")
            ->andWhere("t.id != :taskId")
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

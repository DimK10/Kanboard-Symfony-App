<?php


namespace App\Service;


use App\Entity\Progress;
use App\Entity\User;
use App\Repository\ProgressRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProgressService
{

    private $progressRepository;
    private $entityManager;

    /**
     * ProgressService constructor.
     * @param $progressRepository
     */
    public function __construct(ProgressRepository $progressRepository, EntityManagerInterface $entityManager)
    {
        $this->progressRepository = $progressRepository;
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Progress
    {
        return $this->progressRepository->find($id);
    }

    public function findAllByIdOrderByPriority()
    {
        return $this->progressRepository->findByIdOrderByPriority();
    }

    public function create($workspace): array
    {

        $newProgresses = [];

        $progressDescriptions = [
            "Done",
            "Doing",
            "To Do",
            "To Research"
        ];

        $progressColors = [
            "#FFCC00",
            "#FF9524",
            "#5B8DF4",
            "#B731FF"
        ];

        for ($i = 4; $i > 0; $i--) {
            $newProgress = new Progress();

            $newProgress->setDescription($progressDescriptions[$i-1]);
            $newProgress->setColor($progressColors[$i-1]);
            $newProgress->setPriority($i);
            $newProgress->setWorkspace($workspace);

            array_push($newProgresses, $newProgress);

        }

        return $newProgresses;
    }
}
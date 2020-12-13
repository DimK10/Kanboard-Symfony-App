<?php


namespace App\Service;


use App\Repository\ProgressRepository;

class ProgressService
{

    private $progressRepository;

    /**
     * ProgressService constructor.
     * @param $progressRepository
     */
    public function __construct(ProgressRepository $progressRepository)
    {
        $this->progressRepository = $progressRepository;
    }

    public function findById(int $id) {
        return $this->progressRepository->find($id);
    }

    public function findAllByIdOrderByPriority()
    {
        return $this->progressRepository->findByIdOrderByPriority();
    }
}
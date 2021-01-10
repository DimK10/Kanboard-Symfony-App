<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\Workspace;
use App\Repository\WorkspaceRepository;
use Doctrine\ORM\EntityManagerInterface;

class WorkspaceService
{


    private $workspaceRepository;
    private $entityManager;

    /**
     * WorkspaceService constructor.
     * @param WorkspaceRepository $workspaceRepository
     */
    public function __construct(WorkspaceRepository $workspaceRepository, EntityManagerInterface $entityManager)
    {
        $this->workspaceRepository = $workspaceRepository;
        $this->entityManager = $entityManager;
    }

    public function findById(int $id) {
        return $this->workspaceRepository->find($id);
    }

    public function findAllWorkspacesForAUser(User $user)
    {
        return $this->workspaceRepository->findByAllWorkspacesForSpecificUser($user->getId());
    }

    public function deleteWorkspace($id, User $user)
    {
        $workspaceToRemove = $this->workspaceRepository->find($id);

        $user->removeWorkspaceId($workspaceToRemove);

        $this->entityManager->remove($workspaceToRemove);
        $this->entityManager->flush();
    }
}
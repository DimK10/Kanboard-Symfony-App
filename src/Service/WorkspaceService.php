<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\Workspace;
use App\Repository\WorkspaceRepository;

class WorkspaceService
{


    private $workspaceRepository;

    /**
     * WorkspaceService constructor.
     * @param WorkspaceRepository $workspaceRepository
     */
    public function __construct(WorkspaceRepository $workspaceRepository)
    {
        $this->workspaceRepository = $workspaceRepository;
    }

    public function findById(int $id) {
        return $this->workspaceRepository->find($id);
    }

    public function findAllWorkspacesForAUser(User $user)
    {
        return $this->workspaceRepository->findByAllWorkspacesForSpecificUser($user->getId());
    }
}
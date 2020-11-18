<?php

namespace App\Controller;

use App\Entity\Progress;
use App\Entity\User;
use App\Service\WorkspaceService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class KanbanBoardController extends AbstractController
{
    /**
     * @Route("/kanban/board", name="homepage")
     */
    public function index(WorkspaceService $workspaceService): Response
    {
        $username = $this->getUser()->getUsername();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(["email" => $username])[0];
        $workspaces = $workspaceService->findAllWorkspacesForAUser($user);

        // TODO - Add functionality for multiple workspaces
        // Get all progresses from workspace
        $workspace = $workspaces[0];
        $progresses = $this->getDoctrine()->getRepository(Progress::class)->findBy(["workspace_id" => $workspace->getId()]);
        return $this->render('kanban_board/index.html.twig', [
            'workspaces' => $workspaces,
            'progresses' => $progresses
        ]);
    }
}

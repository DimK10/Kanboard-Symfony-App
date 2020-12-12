<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\ProgressService;
use App\Service\WorkspaceService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class KanbanBoardController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param WorkspaceService $workspaceService
     * @param ProgressService $progressService
     * @return Response
     */
    public function index(UserInterface $userInterface, JWTTokenManagerInterface $JWTTokenManager, WorkspaceService $workspaceService, ProgressService $progressService): Response
    {

//        dd(array("token" => $JWTTokenManager->create($userInterface)));

        $jwt = $JWTTokenManager->create($userInterface);

        $response = new Response();
        $cookie = new Cookie(
            'kanboard_app',
            $jwt,
            time()+3600,
            "/",
            "kanboard-symfony-app.test",
            false,
            true
        );
        $response->headers->setCookie($cookie);
        $response->sendHeaders();

        $username = $this->getUser()->getUsername();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(["email" => $username])[0];
        $workspaces = $workspaceService->findAllWorkspacesForAUser($user);

        // TODO - Add functionality for multiple workspaces
        // Get all progresses from workspace
        $workspace = $workspaces[0];
//        $progresses = $this->getDoctrine()->getRepository(Progress::class)->findBy(["workspace_id" => $workspace->getId()]);
        $progresses = $progressService->findAllByIdOrderByPriority();
        return $this->render('kanban_board/index.html.twig', [
            'workspaces' => $workspaces,
            'progresses' => $progresses,
            $response
        ]);
    }
}

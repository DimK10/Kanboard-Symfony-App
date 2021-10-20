<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\ProgressService;
use App\Service\WorkspaceService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class KanbanBoardController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param UserInterface $userInterface
     * @param JWTTokenManagerInterface $JWTTokenManager
     * @param Request $request
     * @return Response
     */
    public function index(UserInterface $userInterface, JWTTokenManagerInterface $JWTTokenManager, Request $request, WorkspaceService $workspaceService): Response
    {

//        dd(array("token" => $JWTTokenManager->create($userInterface)));

        $jwt = $JWTTokenManager->create($userInterface);

        $response = new Response();
        $cookie = new Cookie(
            'kanboard_app',
            $jwt,
            time()+3600,
            "/",
            "kanboard.applicationonline.site",
            false,
            true
        );
        $response->headers->setCookie($cookie);
        $response->sendHeaders();

        $username = $this->getUser()->getUsername();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(["email" => $username])[0];
//        $workspaces = $workspaceService->findAllWorkspacesForAUser($user);
        $workspaces = $user->getWorkspaces()->getValues();

        $workspace = $user->getWorkspaces()[0];

        $progresses = $user->getWorkspaces()[0]->getProgresses()->getValues();

        // Check if user is trying to change the workspace
        $workspaceChosenId = $request->request->get("workspace_select");

        if ($workspaceChosenId) {
            $workspaceChosen = $workspaceService->findById($workspaceChosenId);
            $workspace = $workspaceChosen;
            $progresses = $workspaceChosen->getProgresses();
        }

        // If the user is new and does not have a workspace
        if (empty($workspace)) {
            return $this->redirectToRoute('app_create_workspace');
        }
        // Get all progresses from workspace




        return $this->render('kanban_board/index.html.twig', [
            'workspaces' => $workspaces,
            'workspace' => $workspace,
            'progresses' => $progresses,
            $response
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Workspace;
use App\Form\WorkspaceFormType;
use App\Service\ProgressService;
use App\Service\WorkspaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkspaceController extends AbstractController
{
    /**
     * @Route("/workspace/create", name="app_create_workspace")
     * @param Request $request
     * @param WorkspaceService $workspaceService
     * @param $progressService
     * @return Response
     */
    public function create(Request $request, WorkspaceService $workspaceService, ProgressService $progressService): Response
    {
        $workspace = new Workspace();

        $workspaceForm = $this->createForm(WorkspaceFormType::class, $workspace, [
            'action' =>$this->generateUrl('app_create_workspace')
        ]);

        $workspaceForm->handleRequest($request);

        if ($workspaceForm->isSubmitted() && $workspaceForm->isValid()) {

            $workspace = $workspaceForm->getData();

            $workspace->addUserId($this->getUser());
            $progresses = $progressService->findAllByIdOrderByPriority();
            $workspace->setProgresses($progresses);
            $workspaceService->save($workspace);

            return $this->redirectToRoute('homepage');
        }



        return $this->render('workspace/index.html.twig', [
            'workspaceForm' => $workspaceForm->createView(),
        ]);
    }
}

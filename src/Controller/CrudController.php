<?php

namespace App\Controller;

use App\Entity\Progress;
use App\Entity\Task;
use App\Entity\Workspace;
use App\Service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CrudController extends AbstractController
{
    /**
     * @Route("/api/task/create", name="create_task", methods={"POST"})
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function createTask(TaskService $taskService, Request $request, SerializerInterface $serializer): JsonResponse
    {

        // Get data from the JSON request body
        $name = $request->request->get('name');
        $description = $request->request->get("description");
        $color = $request->request->get("color");

        // Get progress related with the new task
        $progress = $request->request->get("progress");

        // Get workspace related with the new task
        $workspace = $request->request->get("workspace");

        $priority = $request->request->get("priority");


        // Create new Task and persist
        $newTask = new Task();

        $newTask->setName($name);
        $newTask->setDescription($description);
        $newTask->setColor($color);
        /** @var Progress $progress */
        $newTask->setProgressId($progress);
        /** @var Workspace $workspace */
        $newTask->setWorkspaceId($workspace);
        $newTask->setPriority($priority);

        // persist to db
        $taskService->persist($newTask);

        return new JsonResponse($newTask);
    }
}

<?php

namespace App\Controller;

use App\Entity\Progress;
use App\Entity\Task;
use App\Entity\Workspace;
use App\Service\ProgressService;
use App\Service\TaskService;
use App\Service\WorkspaceService;
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
    public function createTask(TaskService $taskService, Request $request, ProgressService $progressService, WorkspaceService  $workspaceService): JsonResponse
    {

        // Get data from the formData request body
        $name = $request->request->get('name');
        $description = $request->request->get("description");
        $color = $request->request->get("color");

        // Get progress related with the new task
        $progressId =(int) $request->request->get("progress");

        $progress = $progressService->findById($progressId);

        // Get workspace related with the new task
        $workspaceId =(int) $request->request->get("workspace");

        $workspace = $workspaceService->findById($workspaceId);

        $priority =(int) $request->request->get("priority");


        // Create new Task and persist
        $newTask = new Task();

        $newTask->setName($name);
        $newTask->setDescription($description);
        $newTask->setColor($color);
        /** @var Progress $progress */
        $newTask->setProgress($progress);
        /** @var Workspace $workspace */
        $newTask->setWorkspace($workspace);
        $newTask->setPriority($priority);

        // persist to db
        $idOfTask = $taskService->persist($newTask);

        return new JsonResponse([
            "message" => "The task was created successfully",
            "id" => $idOfTask
        ], 201);
    }

    /**
     * @Route("/api/task/delete/{id}", name="delete_task", methods={"POST"})
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function deleteTask($id, TaskService $taskService) {
        $taskDeleted = $taskService->delete($id);

        if ($taskDeleted != null) {
            return new JsonResponse(array("message" =>"Task deleted successfully!"), 200);
        }

        return new JsonResponse(array("message" => "Task not found"), 404);
    }
}

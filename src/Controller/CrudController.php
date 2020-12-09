<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{
    /**
     * @Route("/api/test", name="test_route", methods={"GET"})
     */
    public function testRoute(): JsonResponse
    {
        return new JsonResponse(array("message" => "hello"));
    }
}

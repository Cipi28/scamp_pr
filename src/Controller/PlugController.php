<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlugController extends AbstractController
{
    #[Route('/plug', name: 'app_plug')]
    public function index(): Response
    {
        return $this->render('plug/index.html.twig', [
            'controller_name' => 'PlugController',
        ]);
    }
}

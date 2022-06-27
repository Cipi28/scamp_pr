<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloWorldController extends AbstractController
{

    #[Route("/helloWorld")]

    public function text(): Response
    {

        $userFirstName = 'cipi';
        //return new Response(
        //    '<html><body>Hello World!</body></html>'
        //);

        return $this->render('HelloWorld.html.twig',[
            'user_first_name' => $userFirstName,
        ]);
    }
}
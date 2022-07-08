<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloWorldController extends AbstractController
{

    private $twig;

    #[Route("/helloWorld")]

    public function text(): Response
    {

        $userFirstName = 'cipi';
        //return new Response(
        //    '<html><body>Hello World!</body></html>'
        //);

        return $this->render('base.html.twig',[
            'user_first_name' => $userFirstName,
            'template' => 'HelloWorld.html.twig'
        ]);
    }
}
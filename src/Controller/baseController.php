<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class baseController extends AbstractController
{
    public function navbar(): Response
    {

        $userFirstName = 'cipi';
        //return new Response(
        //    '<html><body>Hello World!</body></html>'
        //);

        return $this->render('navbar.html.twig',[
        ]);
    }

}
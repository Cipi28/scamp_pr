<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Station;
use App\Form\StationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
//    #[Route('/user', name: 'app_user')]
//    public function index(): Response
//    {
//        return $this->render('user/index.html.twig', [
//            'controller_name' => 'UserController',
//        ]);
//    }

    #[Route('/user', name: 'user')]
    public function stationDetails(Request $request, EntityManagerInterface $entityManager): Response
    {
        //dd($id);
        $flag = false;

        //$station = $entityManager->getRepository(Station::class)->find($id);
        //$form = $this->createForm(StationForm::class, $station);
        //$form->handleRequest($request);

        $cars = $entityManager->getRepository(Car::class)->findAll();



//        if ($form->isSubmitted() && $form->isValid()) {
//            $flag = true;
//            // encode the plain password
//            $station->setName($form->get('name')->getData());
//            $station->setLocation($form->get('location')->getData());
//            $station->setLongitude($form->get('longitude')->getData());
//            $station->setLatitude($form->get('latitude')->getData());
//
//            $entityManager->persist($station);
//            $entityManager->flush();
//            // do anything else you need here, like send an email
//
//            //return $this->redirectToRoute('/station/'.$id);
//            //return new RedirectResponse($this->urlGenerator->generate('some_route'));
//        }
//        elseif($flag){
//            throw $this->createNotFoundException(
//                'No product found for ' .$id
//            );
//        }

        //dd($plugs);
//        return $this->render('user/index.html.twig', [
////            'station' => $station,
////            'StationForm' => $form->createView(),
//            'cars' => $cars,
//        ]);

        return $this->render('base.html.twig',[
            'cars' => $cars,
            'template' => 'user/index.html.twig'
        ]);
    }
}

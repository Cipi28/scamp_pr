<?php

namespace App\Controller;

use App\Entity\Plug;
use App\Entity\Station;
use App\Form\PlugForm;
use App\Form\StationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }

    #[Route('/new-car', name: 'create_car')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $form = $this->createForm(CarForm::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $station->setName($form->get('name')->getData());
            $station->setLocation($form->get('location')->getData());
            $station->setLongitude($form->get('longitude')->getData());
            $station->setLatitude($form->get('latitude')->getData());

            $entityManager->persist($station);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_read_station');
        }

        //return new Response('Saved new product with name '.$station->getName());

        return $this->render('station/newStation.html.twig', [
            'StationForm' => $form->createView(),
        ]);
    }
}

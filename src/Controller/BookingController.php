<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Plug;
use App\Form\BookingForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking/{car_id}', name: 'app_booking')]
    public function read($car_id, EntityManagerInterface $entityManager, Request $request): Response
    {

        $car = $entityManager->getRepository(Car::class)->find($car_id);
//        return $this->render('booking/index.html.twig', [
//            'car' => $car,
//        ]);
        $booking = new Booking();
        $form = $this->createForm(BookingForm::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $booking->setStartTime($form->get('startTime')->getData());
            $booking->setDuration($form->get('duration')->getData());
            $booking->setCarId($car);

            $entityManager->persist($booking);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('available_plugs', ['booking_id' => $booking->getId()]);
        }

        return $this->render('base.html.twig',[
            'car' => $car,
            'BookingForm' => $form->createView(),
            'template' => 'booking/index.html.twig'
        ]);
    }

    #[Route(['/available_plugs/{booking_id}'], name: 'available_plugs')]
    public function availablePlugs(EntityManagerInterface $entityManager, $booking_id) {

        $availablePLugs = $entityManager->getRepository(Plug::class)->findAll() ;

//        return $this->render('station/afisName.html.twig', [
//            'stations' => $stations,
//        ]);

        return $this->render('base.html.twig',[
            'availablePlugs' => $availablePLugs,
            'booking_id' => $booking_id,
            'template' => 'booking/availablePlugs.html.twig'
        ]);
    }

    #[Route('/add_plug/{booking_id}/{plug}', name: 'app_add_plug')]
    public function addPlug(ManagerRegistry $doctrine, $booking_id, Plug $plug): Response
    {
        $entityManager = $doctrine->getManager();
        $booking = $entityManager->getRepository(Plug::class)->find($booking_id);
        //dd($booking->getStationId()->getId());

        if (!$booking) {
            throw $this->createNotFoundException(
                'No booking found for id '.$booking_id

            );
        }

        $booking->setPlugId($plug);

        $entityManager->persist($booking);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $booking->getId()
        //]);
        //return new Response('Station Deleted');
        return $this->redirectToRoute('users');
    }
}

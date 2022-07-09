<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Form\BookingForm;
use Doctrine\ORM\EntityManagerInterface;
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

            $entityManager->persist($booking);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('user');
        }

        return $this->render('base.html.twig',[
            'car' => $car,
            'BookingForm' => $form->createView(),
            'template' => 'booking/index.html.twig'
        ]);
    }
}

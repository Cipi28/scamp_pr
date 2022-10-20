<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Plug;
use App\Entity\Station;
use App\Entity\UserCar;
use App\Form\BookingForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlugRepository;

class BookingController extends AbstractController
{
    #[Route('/booking/{car_id}', name: 'app_booking')]
    public function createBooking($car_id, EntityManagerInterface $entityManager, Request $request): Response
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
            $car->setBookingId($booking);

            $entityManager->persist($booking);
            $entityManager->flush();
            // do anything else you need here, like send an email
            //dd($booking->getId());
            return $this->redirectToRoute('available_plugs', ['booking_id' => $booking->getId()]);
        }

        return $this->render('base.html.twig',[
            'car' => $car,
            'BookingForm' => $form->createView(),
            'template' => 'booking/index.html.twig'
        ]);
    }

    #[Route(['/read-bookings'], name: 'app_read_bookings')]
    public function read(EntityManagerInterface $entityManager) {

        $bookings = $entityManager->getRepository(Booking::class)->findAll() ;

//        return $this->render('station/afisName.html.twig', [
//            'stations' => $stations,
//        ]);
        $bookingss[] = new Booking();
        array_splice($bookingss, 0, 1);
//        $cars = $entityManager->getRepository(Car::class)->findAll();
        $relations = $entityManager->getRepository(UserCar::class)->findAll();

        foreach ($relations as $relation){
            if($relation->getUser() == $this->getUser()) {
                if($relation->getCar()->getBookingId() != NULL) {
                    array_push($bookingss, $relation->getCar()->getBookingId());
                }
            }
        }
//        dd($bookingss);

        return $this->render('base.html.twig',[
            'bookings' => $bookingss,
            'template' => 'booking/bookingList.html.twig'
        ]);
    }

    #[Route(['/available_plugs/{booking_id}'], name: 'available_plugs')]
    public function availablePlugs(EntityManagerInterface $entityManager, int $booking_id) {
        $availablePlugs = $entityManager->getRepository(Plug::class)->findByStatus() ;
        $bookings = $entityManager->getRepository(Booking::class)->findAll() ;
        $specificBooking = $entityManager->getRepository(Booking::class)->find($booking_id) ;
        $specificStartTime = $specificBooking->getStartTime();
        $specificEndTime = $specificBooking->getStartTime();
        $specificEndTime->add($specificBooking->getDuration());
        foreach ($bookings as $booking){
            $StartTime= $booking->getStartTime();
            $EndTime = $booking->getStartTime();
            $EndTime->add($booking->getDuration());
            if($booking->getId() != $specificBooking->getId()) {
                if (($EndTime >= $specificStartTime && $EndTime <= $specificEndTime) || ($StartTime >= $specificStartTime && $StartTime <= $specificEndTime) || ($StartTime <= $specificStartTime && $EndTime >= $specificEndTime) || ($StartTime >= $specificStartTime && $EndTime <= $specificEndTime)) {
                    if ($booking->getPlugId() != NULL) {
                        for ($i = 0; $i < count($availablePlugs); $i++) {
                            if ( $availablePlugs[$i]->getId() == $booking->getPlugId()->getId()) {
                                array_splice($availablePlugs, $i, 1);
                            }
                        }
                    }
                }
            }
        }
        $entityManager->flush();

//        return $this->render('station/afisName.html.twig', [
//            'stations' => $stations,
//        ]);

        return $this->render('base.html.twig',[
            'availablePlugs' => $availablePlugs,
            'booking_id' => $booking_id,
            'template' => 'booking/availablePlugs.html.twig'
        ]);
    }

    #[Route('/add_plug/{booking_id}/{plug_id}', name: 'app_add_plug')]
    public function addPlug(ManagerRegistry $doctrine, int $booking_id, int $plug_id): Response
    {
        $entityManager = $doctrine->getManager();
        $booking = $entityManager->getRepository(Booking::class)->find($booking_id);
        //dd($booking->getStationId()->getId());

        if (!$booking) {
            throw $this->createNotFoundException(
                'No booking found for id '.$booking_id

            );
        }
        $plug = $entityManager->getRepository(Plug::class)->find($plug_id);

        $booking->setPlugId($plug);

        $entityManager->persist($booking);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $booking->getId()
        //]);
        //return new Response('Station Deleted');
        return $this->redirectToRoute('user');
    }

    #[Route('/remove-booking/{car_id}', name: 'app_remove_booking')]
    public function remove(ManagerRegistry $doctrine, $car_id): Response
    {
        $entityManager = $doctrine->getManager();
        $car = $entityManager->getRepository(Car::class)->find($car_id);
        $booking =  $car->getBookingId();
        //dd($product->getStationId()->getId());

        if (!$car) {
            throw $this->createNotFoundException(
                'No car found for id '.$car_id
            );
        }

        $car->setBookingId(NULL);
        $booking->setCar(NULL);

        $entityManager->remove($booking);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $product->getId()
        //]);
        //return new Response('Station Deleted');
        return $this->redirectToRoute('user');
    }
}

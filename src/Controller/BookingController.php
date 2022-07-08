<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking/{car_id}', name: 'app_booking')]
    public function read($car_id, EntityManagerInterface $entityManager): Response
    {

        $car = $entityManager->getRepository(Car::class)->find($car_id);
//        return $this->render('booking/index.html.twig', [
//            'car' => $car,
//        ]);

        return $this->render('base.html.twig',[
            'car' => $car,
            'template' => 'booking/index.html.twig'
        ]);
    }
}

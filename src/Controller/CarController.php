<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\UserCar;
use App\Entity\Plug;
use App\Entity\Station;
use App\Form\CarForm;
use App\Form\PlugForm;
use App\Form\StationForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
//    #[Route('/car', name: 'app_car')]
//    public function index(): Response
//    {
//        return $this->render('car/index.html.twig', [
//            'controller_name' => 'CarController',
//        ]);
//    }

    #[Route('/new-car', name: 'new_car')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $join = new UserCar();
        $form = $this->createForm(CarForm::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $car->setPlate($form->get('plate')->getData());
            $car->setPlugType($form->get('plugType')->getData());
            $car->addUserId($this->getUser());
            $join->setCar($car);
            $join->setUser($this->getUser());
            $entityManager->persist($car);
            $entityManager->persist($join);
            $entityManager->flush();
            //dd($car->getUserId());
            // do anything else you need here, like send an email

            return $this->redirectToRoute('user');
        }


        return $this->render('base.html.twig',[
            'CarForm' => $form->createView(),
            'template' => 'car/newCar.html.twig'
        ]);
    }

    #[Route('/car/{id}', name: 'car_details')]
    public function carDetails($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        //dd($id);
        $flag = false;

        $car = $entityManager->getRepository(Car::class)->find($id);
        $form = $this->createForm(CarForm::class, $car);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $flag = true;
            // encode the plain password
            $car->setPlate($form->get('plate')->getData());
            $car->setPlugType($form->get('plugType')->getData());

            $entityManager->persist($car);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //return $this->redirectToRoute('/station/'.$id);
            //return new RedirectResponse($this->urlGenerator->generate('some_route'));
        }
        elseif($flag){
            throw $this->createNotFoundException(
                'No product found for ' .$id
            );
        }

        //dd($car);
//        return $this->render('car/CarDetails.html.twig', [
//            'car' => $car,
//            'CarForm' => $form->createView(),
////            'plugs' => $plugs,
//        ]);

        return $this->render('base.html.twig',[
            'car' => $car,
            'CarForm' => $form->createView(),
            'template' => 'car/CarDetails.html.twig'
        ]);
    }

    #[Route('/remove-car/{id}', name: 'app_remove_car')]
    public function remove(ManagerRegistry $doctrine, $id): Response
    {

        $entityManager = $doctrine->getManager();

        $car = $entityManager->getRepository(Car::class)->find($id);
        //dd($product->getStationId()->getId());

        if (!$car) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        if($car->getBookingId() != NULL) {

            $booking = $car->getBookingId();
            $car->setBookingId(NULL);
            $booking->setCar(NULL);
            $entityManager->remove($booking);
            $entityManager->flush();
        }


        $joins = $entityManager->getRepository(UserCar::class)->findAll();
        foreach ($joins as $join){
            if($join->getCar() == $car) {
                $entityManager->remove($join);
                $entityManager->flush();
            }
        }


        $entityManager->remove($car);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $product->getId()
        //]);
        //return new Response('Station Deleted');
        return $this->redirectToRoute('user');
    }

}

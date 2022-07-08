<?php

namespace App\Controller;

use App\Entity\Car;
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
        $form = $this->createForm(CarForm::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $car->setPlate($form->get('plate')->getData());
            $car->setPlugType($form->get('plugType')->getData());

            $entityManager->persist($car);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('user');
        }

        //return new Response('Saved new product with name '.$station->getName());

//        return $this->render('car/newCar.html.twig', [
//            'CarForm' => $form->createView(),
//        ]);

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
        $product = $entityManager->getRepository(Car::class)->find($id);
        //dd($product->getStationId()->getId());

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }


        $entityManager->remove($product);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $product->getId()
        //]);
        //return new Response('Station Deleted');
        return $this->redirectToRoute('user');
    }

}

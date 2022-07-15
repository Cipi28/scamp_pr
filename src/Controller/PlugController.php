<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Plug;
use App\Entity\Station;
use App\Entity\UserCar;
use App\Form\StationForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PlugForm;

class PlugController extends AbstractController
{
    #[Route('/plug/{id}', name: 'plug_details')]
    public function plugDetails($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        //dd($id);
        $flag = false;

        $plug = $entityManager->getRepository(Plug::class)->find($id);
        $form = $this->createForm(PlugForm::class, $plug);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $flag = true;
            // encode the plain password
            $plug->setType($form->get('type')->getData());
            $plug->setStatus($form->get('status')->getData());

            $entityManager->persist($plug);
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

        //dd($plugs);
//        return $this->render('plug/PlugDetails.html.twig', [
//            'plug' => $plug,
//            'PlugForm' => $form->createView(),
////            'plugs' => $plugs,
//        ]);

        return $this->render('base.html.twig',[
            'plug' => $plug,
            'PlugForm' => $form->createView(),
            'template' => 'plug/PlugDetails.html.twig'
        ]);
    }

//    #[Route('/plug', name: 'app_plug')]
//    public function index(): Response
//    {
//        return $this->render('plug/index.html.twig', [
//            'controller_name' => 'PlugController',
//        ]);
//    }

    #[Route('/new-plug/{station_id}', name: 'create_plug')]
    public function create(Request $request, EntityManagerInterface $entityManager, Station $station_id): Response
    {
        $plug = new Plug();
        $form = $this->createForm(PlugForm::class, $plug);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            $plug->setType($form->get('type')->getData());
            $plug->setStatus($form->get('status')->getData());
            //dd($station_id);
            $plug->setStationId($station_id);


            $entityManager->persist($plug);
            $entityManager->flush();
            // do anything else you need here, like send an email
            //dd((array)$plug->getStationId()->getId());
            return $this->redirectToRoute('station_details', ['id' => $station_id->getId()]);
        }


        //return new Response('Saved new product with name '.$station->getName());

        //dd($plug);
//        return $this->render('plug/newPlug.html.twig', [
//            'PlugForm' => $form->createView(),
//        ]);

        return $this->render('base.html.twig',[
            'PlugForm' => $form->createView(),
            'template' => 'plug/newPlug.html.twig'
        ]);
    }

    #[Route('/remove-plug/{id}', name: 'app_remove_plug')]
    public function remove(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Plug::class)->find($id);
        //dd($product->getStationId()->getId());

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }


        $bookings = $entityManager->getRepository(Booking::class)->findAll();
        foreach ($bookings as $booking){
            if($booking->getPlugId() != NULL && $booking->getPlugId() == $product) {
                $booking->setPlugId(NULL);
                $entityManager->flush();
            }
        }


        $entityManager->remove($product);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $product->getId()
        //]);
        //return new Response('Station Deleted');
        return $this->redirectToRoute('station_details', ['id' => $product->getStationId()->getId()]);
    }
}

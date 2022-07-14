<?php

namespace App\Controller;

use App\Entity\Plug;
use App\Form\RegistrationFormType;
use App\Form\StationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Station;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PlugRepository;

class StationController extends AbstractController
{
    #[Route('/station/{id}', name: 'station_details')]
    public function stationDetails($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        //dd($id);
        $flag = false;

        $station = $entityManager->getRepository(Station::class)->find($id);
        $form = $this->createForm(StationForm::class, $station);
        $form->handleRequest($request);

        $plugs = $entityManager->getRepository(Plug::class)->findByStationId($id);


        if ($form->isSubmitted() && $form->isValid()) {
            $flag = true;
            // encode the plain password
            $station->setName($form->get('name')->getData());
            $station->setLocation($form->get('location')->getData());
            $station->setLongitude($form->get('longitude')->getData());
            $station->setLatitude($form->get('latitude')->getData());

            $entityManager->persist($station);
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
//        return $this->render('station/StationDetails.html.twig', [
//            'station' => $station,
//            'StationForm' => $form->createView(),
//            'plugs' => $plugs,
//        ]);

        return $this->render('base.html.twig',[
            'station' => $station,
            'StationForm' => $form->createView(),
            'plugs' => $plugs,
            'template' => 'station/StationDetails.html.twig'
        ]);
    }


    #[Route('/new-station', name: 'create_station')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $station = new Station();
        $form = $this->createForm(StationForm::class, $station);
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

//        return $this->render('station/newStation.html.twig', [
//            'StationForm' => $form->createView(),
//        ]);

        return $this->render('base.html.twig',[
            'StationForm' => $form->createView(),
            'template' => 'station/newStation.html.twig'
        ]);
    }

    #[Route('/read-station', name: 'app_read_station')]
    public function read(EntityManagerInterface $entityManager) {

        $stations = $entityManager->getRepository(Station::class)->findAll() ;

//        return $this->render('station/afisName.html.twig', [
//            'stations' => $stations,
//        ]);

        return $this->render('base.html.twig',[
            'stations' => $stations,
            'template' => 'station/afisName.html.twig'
        ]);
    }

    /* #[Route('/update-station', name: 'app_update_station')]
    public function update(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Station::class)->find(1);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id 1'
            );
        }

        $product->setName('Station(Updated)');
        $entityManager->flush();


        //return $this->redirectToRoute('product_show', [
        //    'id' => $product->getId()
        //]);
        return new Response('Station Updated');
    } */

    #[Route('/remove-station/{id}', name: 'app_remove_station_{id}')]
    public function remove(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Station::class)->find($id);

        $productPlug = $entityManager->getRepository(Plug::class)->findByStationId($id);
        foreach ($productPlug as $plug){
            $entityManager->remove($plug);
        }
        $entityManager->flush();


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
        return $this->redirectToRoute('app_read_station');
    }
}

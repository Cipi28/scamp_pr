<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Station;
use Doctrine\Persistence\ManagerRegistry;

class StationController extends AbstractController
{
    #[Route('/station', name: 'create_station')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $station = new Station();
        $entityManager = $doctrine->getManager();

        $station->setName('StationNR'.rand());
        $station->setLatitude(rand());
        $station->setLongitude(rand());

        $entityManager->persist($station);

        $entityManager->flush();

        return new Response('Saved new product with name '.$station->getName());

        //return $this->render('station/afisName.html.twig', [
        //    'station_name' => $station->getName(),
        //]);
    }

    #[Route('/read-station', name: 'app_read_station')]
    public function read(EntityManagerInterface $entityManager) {

        $stations = $entityManager->getRepository(Station::class)->findAll() ;

        return $this->render('station/afisName.html.twig', [
            'stations' => $stations,
        ]);
    }

    #[Route('/update-station', name: 'app_update_station')]
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
    }

    #[Route('/remove-station', name: 'app_remove_station')]
    public function remove(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Station::class)->find(8);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id 8'
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        //return $this->redirectToRoute('product_show', [
        //    'id' => $product->getId()
        //]);
        return new Response('Station Deleted');
    }
}

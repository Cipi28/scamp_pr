<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Station;
use Doctrine\Persistence\ManagerRegistry;

class StationController extends AbstractController
{
    #[Route('/station', name: 'app_station')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $station = new Station();
        $station->setName('StationNR'.rand());
        $station->setLatitude(rand());
        $station->setLongitude(rand());

        $entityManager->persist($station);

        $entityManager->flush();

        //return new Response('Saved new product with name '.$station->getName());

        return $this->render('station/afisName.html.twig', [
            'station_name' => $station->getName(),
        ]);
    }

    #[Route('/read-station', name: 'app_read_station')]
    public function read(EntityManagerInterface $entityManager) {

        $stations = $entityManager->getRepository(Station::class)->findAll() ;



        return $this->render('station/afisName.html.twig', [
            'stations' => $stations,
        ]);
    }
}

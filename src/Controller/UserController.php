<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\UserCar;
use App\Entity\Station;
use App\Form\StationForm;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
//    #[Route('/user', name: 'app_user')]
//    public function index(): Response
//    {
//        return $this->render('user/index.html.twig', [
//            'controller_name' => 'UserController',
//        ]);
//    }

    #[Route(['/' ,'/user'], name: 'user')]
    public function stationDetails(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cars[] = new Car();
        array_splice($cars, 0, 1);
//        $cars = $entityManager->getRepository(Car::class)->findAll();
        $relations = $entityManager->getRepository(UserCar::class)->findAll();

        foreach ($relations as $relation){
            if($relation->getUser() == $this->getUser()) {
                array_push($cars, $relation->getCar());
            }
        }


        return $this->render('base.html.twig',[
            'cars' => $cars,
            'template' => 'user/index.html.twig'
        ]);
    }
}

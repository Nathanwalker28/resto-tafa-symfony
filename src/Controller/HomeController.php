<?php

namespace App\Controller;

use App\Repository\DishRepository;
use App\Repository\OrderedRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Page d'acceuil
     * 
     * @Route("/", name="app_home")
     */
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'dishes' => $dishRepository->findMaxQuantitySold()
        ]);
    }
}

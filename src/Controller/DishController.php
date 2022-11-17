<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DishController extends AbstractController
{
    /**
     * @Route("/dish", name="app_dish_home")
     */
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('dish/index.html.twig', [
            'dishes' => $dishRepository->findAll()
        ]);
    }

    /**
     * @Route("/dish/create", name="app_dish_create")
     */
    public function create(): Response
    {   
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        
        return $this->render('dish/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

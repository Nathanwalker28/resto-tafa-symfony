<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Ordered;
use App\Form\OrderedType;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderedController extends AbstractController
{
    /**
     * @Route("/dish/{id}", name="app_dish_show", methods="GET")
     */
    public function show(DishRepository $dishRepository, $id): Response
    {
        $ordered = new Ordered();
        $dish = $dishRepository->find($id);

        $form = $this->createForm(OrderedType::class, $ordered);

        return $this->render('ordered/ordered.html.twig', [
            'dish' => $dish,
            'form' => $form->createView()
        ]);
    }
}

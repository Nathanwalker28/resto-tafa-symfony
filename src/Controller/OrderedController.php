<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Ordered;
use App\Form\OrderedType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderedController extends AbstractController
{
    /**
     * permettre à l'utilisateur de choisir un plat 
     * et de valider son choix
     * 
     * @Route("/dish/{id}", name="app_dish_show")
     * @IsGranted("ROLE_USER")
     * 
     */
    public function show(DishRepository $dishRepository, Request $request, EntityManagerInterface $manager, Dish $dish, SessionInterface $session)
    {
        $ordered = new Ordered();

        $form = $this->createForm(OrderedType::class, $ordered);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            

            if ($ordered->getQuantity() > $dish->getQuantity()) {

                $this->addFlash(
                    "warning",
                    "il n'y a plus assez pour votre commande, Veuillez réessayer s'il vous plait"
                );
            } else {
                $ordered->setUserOrder($this->getUser());
                $ordered->setDish($dish);
                $ordered->setCreatedAd(new \Datetime());

                $dish->setQuantity($dish->getQuantity() - $ordered->getQuantity());
                $dish->setQuantitySold($dish->getQuantitySold() + $ordered->getQuantity());

                $manager->persist($ordered);
                $manager->persist($dish);

                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre commande est enregistré avec succès!"
                );

                return $this->render('ordered/ordered.html.twig', [
                    'dish' => $dish,
                    'form' => $form->createView()
                ]);
            }
        }

        return $this->render('ordered/ordered.html.twig', [
            'dish' => $dish,
            'form' => $form->createView()
        ]);
    }
}

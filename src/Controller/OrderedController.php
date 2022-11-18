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

class OrderedController extends AbstractController
{
    /**
     * @Route("/dish/{id}", name="app_dish_show")
     * @IsGranted("ROLE_USER")
     * 
     */
    public function show(DishRepository $dishRepository, Request $request, EntityManagerInterface $manager, Dish $dish)
    {
        $ordered = new Ordered();
        
        $form = $this->createForm(OrderedType::class, $ordered);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $ordered->setUserOrder($this->getUser());

            $ordered->setDish($dish);
            
            $ordered->setCreatedAd(new \Datetime());

            if($ordered->getQuantity() < $dish->getQuantity() ) {
                $dish->setQuantity($ordered->getQuantity() - $dish->getQuantity());
                
                $manager->persist($ordered);
                $manager->persist($dish);

                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre commande est enregistré avec succès!"
                );
            }else{
                $this->addFlash(
                    "warning",
                    "il n'y a plus assez pour votre commande, Veuillez réessayer s'il vous plait" 
                );
            }

        }

        return $this->render('ordered/ordered.html.twig', [
            'dish' => $dish,
            'form' => $form->createView()
        ]);
    }
}

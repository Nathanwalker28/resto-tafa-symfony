<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DishController extends AbstractController
{
    /**
     * @Route("/dish", name="app_dish")
     */
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('dish/index.html.twig', [
            'dishes' => $dishRepository->findAll()
        ]);
    }

    

    /**
     * @Route("/dish/create", name="app_dish_create")
     * @isGranted("ROLE_USER")
     */
    public function create(Request $request, FileUploader $fileUploader, EntityManagerInterface $manager): Response
    {   
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $coverImage = $form->get('coverImage')->getData();

            if ($coverImage) {
                $coverImageFileName = $fileUploader->upload($coverImage);
                $dish->setCoverImage($coverImageFileName);

                $dish->setCreateAt(new \Datetime());

                $manager->persist($dish);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre nouveau plat est enregistré avec succèss !'
                );  

                return $this->redirectToRoute('app_dish_home');
            }
        }
        
        return $this->render('dish/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

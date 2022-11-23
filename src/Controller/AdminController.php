<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
* @Route("admin", name="app_admin_")
*/
class AdminController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index(){

        return $this->render("admin/index.html.twig", [

        ]);

    }
    
    /**
     * liste des utilisateurs du site
     *
     * @Route("/users/", name="users")
     */
    public function usersList(UserRepository $userRepository)
    {
        return $this->render("admin/users.html.twig", [
            "users" => $userRepository->findAll()
        ]);
    }
    
    /**
     * edit
     *
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'utilisateur modifié avec succès'
            );

            return $this->redirectToRoute("app_admin_users");
        }

        return $this->render("admin/edit.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
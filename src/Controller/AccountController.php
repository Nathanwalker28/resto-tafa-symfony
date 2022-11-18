<?php

namespace App\Controller;

use App\Entity\Ordered;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegistrationType;
use App\Repository\DishRepository;
use App\Repository\OrderedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/register", name="app_account_register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response 
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a été bien crée, veuillez vous connecter'
            );

            return $this->redirectToRoute('app_account_login');
        }
        
        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/login", name="app_account_login")
     * 
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dish');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * 
     * @Route("account/profil", name="app_account_profil")
    */
    public function show(OrderedRepository $orderedRepository, DishRepository $dishRepository): Response
    {

        $ordereds = $orderedRepository->findByuserOrder($this->getUser()->getId());


       
        return $this->render("account/profil.html.twig", [
            'ordereds' => $ordereds
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @IsGranted("ROLE_USER")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

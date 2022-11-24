<?php

namespace App\Controller;


use App\Entity\Dish;
use App\Service\Cart;
use App\Entity\Ordered;
use App\Form\OrderedType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/cart", name="cart_")
 * @isGranted("ROLE_USER")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Cart $cart, DishRepository $dishRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $cartData = $cart->getCartProduct();

        $totalPrice = 0;

        foreach($cartData as $data) {
            $totalData = $data['dish']->getPrice() * $data['quantity'];
            $totalPrice += $totalData;
        }

        return $this->render('cart/index.html.twig', [
            'cartData' => $cartData,
            'totalPrice' => $totalPrice
        ]);
    }
    
    
    
    /**
     * add
     *
     * @Route("/add/{id}", name="add")
     */
    public function add($id, Cart $cart)
    {
        $cart->add($id);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * add
     *
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, Cart $cart)
    {
        $cart->remove($id);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * add
     *
     * @Route("/decrease/{id}", name="decrease")
     */
    public function decrease($id, Cart $cart)
    {
        $cart->remove($id);

        return $this->redirectToRoute('cart_index');
    }

    
    /**
     * command
     *
     * @Route("/send", name="send")
     */
    public function send(Cart $cart, DishRepository $dishRepository, Request $request, EntityManagerInterface $manager)
    {
        $ordered = new Ordered();

        $cartData = $cart->getCartProduct();

        $totalPrice = 0;

        foreach($cartData as $data) {
            $ordered->setUserOrder($this->getUser());
            $ordered->setDish($data['dish']);
            $ordered->setCreatedAd(new \Datetime());

            $data['dish']->setQuantity($data['dish']->getQuantity() - $data['quantity']);
            $data['dish']->setQuantitySold($data['dish']->getQuantitySold() + $data['quantity']);
        

            $ordered->setQuantity($data['quantity']);

            $manager->persist($ordered);
            $manager->persist($data['dish']);

            
            $cart->remove($data['dish']->getId());
            
        }
        $manager->flush();
        
        

        $this->addFlash(
            'success',
            "Votre commande est enregistré avec succès!"
        );

        return $this->redirectToRoute('cart_index');
    }

}

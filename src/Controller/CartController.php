<?php

namespace App\Controller;


use App\Entity\Dish;
use App\Entity\Ordered;
use App\Form\OrderedType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/cart", name="cart_")
 * @isGranted("ROLE_USER")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, DishRepository $dishRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $cart = $session->get('cart', []);

        $cartData = [];

        foreach ($cart as $id => $quantity) {
            $cartData[] = [
                'dish' => $dishRepository->find($id),
                'quantity' => $quantity
            ];
        }

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
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * add
     *
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        } 

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * add
     *
     * @Route("/decrease/{id}", name="decrease")
     */
    public function decrease($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]--;
        }
        
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

}

<?php 
namespace App\Service;

use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    protected $session;
    protected $dishRepository;

    public function __construct(SessionInterface $session, DishRepository $dishRepository)
    {
        $this->session = $session; 
        $this->dishRepository = $dishRepository;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function remove($id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        } 

        $this->session->set('cart', $cart);
    }

    public function getCartProduct()
    {
        $cart = $this->session->get('cart', []);

        $cartProduct = [];

        foreach ($cart as $id => $quantity) {
            $cartProduct[] = [
                'dish' => $this->dishRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $cartProduct;
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]--;

            if($cart[$id] === 0) {
                unset($cart[$id]);
            } 
        }
        
        $this->session->set('cart', $cart);
    }
    public function getTotal()
    {

    }
}
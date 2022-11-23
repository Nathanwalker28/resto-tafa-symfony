<?php 

namespace App\Entity;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class cart
{

    private $session;
    
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }



    public function add($id)
    {

        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        return $this->session->set('cart', $cart);
    }
}
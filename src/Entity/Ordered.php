<?php

namespace App\Entity;

use App\Repository\OrderedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderedRepository::class)
 */
class Ordered
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ordereds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Dish::class, inversedBy="ordereds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dish;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAd;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserOrder(): ?User
    {
        return $this->userOrder;
    }

    public function setUserOrder(?User $userOrder): self
    {
        $this->userOrder = $userOrder;

        return $this;
    }

    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    public function setDish(?Dish $dish): self
    {
        $this->dish = $dish;

        return $this;
    }

    public function getCreateAd(): ?\DateTimeInterface
    {
        return $this->createAd;
    }

    public function setCreateAd(\DateTimeInterface $createAd): self
    {
        $this->createAd = $createAd;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}

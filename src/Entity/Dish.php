<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=DishRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"name"}, 
 *      message = "Ce plat existe déja, veuillez vérifier!"
 * )
 */
class Dish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom du plat ne doit pas être vide")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Veuillez ajouter une description")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez renseigner les ingredients")
     */
    private $ingredients;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message="il y a une erreur")
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=Ordered::class, mappedBy="dish")
     */
    private $ordereds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantitySold;


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->quantity = $this->quantity - $this->$this->ordered->quantity;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->ordereds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Ordered>
     */
    public function getOrdereds(): Collection
    {
        return $this->ordereds;
    }

    public function addOrdered(Ordered $ordered): self
    {
        if (!$this->ordereds->contains($ordered)) {
            $this->ordereds[] = $ordered;
            $ordered->setDish($this);
        }

        return $this;
    }

    public function removeOrdered(Ordered $ordered): self
    {
        if ($this->ordereds->removeElement($ordered)) {
            // set the owning side to null (unless already changed)
            if ($ordered->getDish() === $this) {
                $ordered->setDish(null);
            }
        }

        return $this;
    }

    public function getQuantitySold(): ?int
    {
        return $this->quantitySold;
    }

    public function setQuantitySold(?int $quantitySold): self
    {
        $this->quantitySold = $quantitySold;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingListRepository::class)
 * @UniqueEntity("name")
 */
class ShoppingList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingListProduct::class, mappedBy="shopping_list")
     */
    private $shoppingListProducts;

    public function __construct()
    {
        $this->shoppingListProducts = new ArrayCollection();
        $this->creation_date = new \DateTime();
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * @return Collection|ShoppingListProduct[]
     */
    public function getShoppingListProducts(): Collection
    {
        return $this->shoppingListProducts;
    }

    public function addShoppingListProduct(ShoppingListProduct $shoppingListProduct): self
    {
        if (!$this->shoppingListProducts->contains($shoppingListProduct)) {
            $this->shoppingListProducts[] = $shoppingListProduct;
            $shoppingListProduct->setShoppingList($this);
        }

        return $this;
    }

    public function removeShoppingListProduct(ShoppingListProduct $shoppingListProduct): self
    {
        if ($this->shoppingListProducts->removeElement($shoppingListProduct)) {
            // set the owning side to null (unless already changed)
            if ($shoppingListProduct->getShoppingList() === $this) {
                $shoppingListProduct->setShoppingList(null);
            }
        }

        return $this;
    }
}

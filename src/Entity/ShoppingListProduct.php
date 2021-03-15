<?php

namespace App\Entity;

use App\Repository\ShoppingListProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingListProductRepository::class)
 */

/**
 * @ORM\Entity(repositoryClass=ShoppingListProductRepository::class)
 */
class ShoppingListProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ShoppingList::class, inversedBy="shoppingListProducts")
     */
    private $shopping_list;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="shoppingListProducts")
     */
    private $product;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */

    private $quantity = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shopping_list;
    }

    public function setShoppingList(?ShoppingList $shopping_list): self
    {
        $this->shopping_list = $shopping_list;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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
}

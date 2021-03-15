<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingListProduct::class, mappedBy="product")
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $shoppingListProduct->setProduct($this);
        }

        return $this;
    }

    public function removeShoppingListProduct(ShoppingListProduct $shoppingListProduct): self
    {
        if ($this->shoppingListProducts->removeElement($shoppingListProduct)) {
            // set the owning side to null (unless already changed)
            if ($shoppingListProduct->getProduct() === $this) {
                $shoppingListProduct->setProduct(null);
            }
        }

        return $this;
    }
}

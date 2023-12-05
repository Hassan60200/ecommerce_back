<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\AdminController;
use App\Controller\CategoryController;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
        new Get(
//            uriTemplate: '/category/:id',
//            controller: CategoryController::class,
//            name: 'app_category_show'
        ),
        new GetCollection(
//            uriTemplate: '/categories/',
//            controller: CategoryController::class,
//            name: 'app_category'
        ),
        new Get(
            uriTemplate: '/admin/categories/{id}/',
        ),
        new GetCollection(
            uriTemplate: '/admin/categories/',
        ),
        new Post(
            uriTemplate: '/admin/categories/add',
        ),
        new Put(
            uriTemplate: '/admin/categories/edit/{id}',
        ),
        new Delete(
            uriTemplate: '/admin/categories/delete/{id}',
        ),
    ],
    normalizationContext: ['groups' => ['read_category']],
    denormalizationContext: ['groups' => ['write_category']]
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_product', 'write_product', 'read_category'])]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups(['read_product', 'write_product', 'read_category', 'write_category'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_category', 'write_category'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'Category', targetEntity: Product::class, cascade: ['remove'])]
    private Collection $products;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

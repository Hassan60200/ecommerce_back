<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CarrierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/admin/carrier/{id}',
        ),
        new GetCollection(
            uriTemplate: '/admin/carrier/',
        ),
        new Post(
            uriTemplate: '/admin/carrier/new',
        ),
        new Put(
            uriTemplate: '/admin/carrier/edit/{id}',
        ),
        new Delete(
            uriTemplate: '/admin/carrier/delete/{id}',
        ),
    ],
    normalizationContext: ['groups' => ['read_carrier']],
    denormalizationContext: ['groups' => ['write_carrier']]
)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_carrier', 'write_carrier'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_carrier', 'write_carrier'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read_carrier', 'write_carrier'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['read_carrier', 'write_carrier'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['read_carrier', 'write_carrier'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]

    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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

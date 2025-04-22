<?php

namespace App\Entity\Recipe;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\Recipe\RecipeStepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: RecipeStepRepository::class)]
class RecipeStep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $stepOrder = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $instruction = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    public function __toString(): string
    {
        return $this->stepOrder;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepOrder(): ?int
    {
        return $this->stepOrder;
    }

    public function setStepOrder(int $stepOrder): static
    {
        $this->stepOrder = $stepOrder;

        return $this;
    }

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(string $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }
}

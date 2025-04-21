<?php

namespace App\Entity\Planning;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Recipe\Recipe;
use App\Repository\Planning\MealRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $mealTime = null;

    #[ORM\ManyToOne]
    private ?Recipe $recipe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?float $estimatedCalories = null;

    #[ORM\Column(nullable: true)]
    private ?float $estimatedProteins = null;

    #[ORM\Column(nullable: true)]
    private ?float $estimatedFats = null;

    #[ORM\Column(nullable: true)]
    private ?float $estimatedCarbs = null;

    #[ORM\Column(length: 255)]
    private ?string $mealSource = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMealTime(): ?string
    {
        return $this->mealTime;
    }

    public function setMealTime(string $mealTime): static
    {
        $this->mealTime = $mealTime;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getEstimatedCalories(): ?float
    {
        return $this->estimatedCalories;
    }

    public function setEstimatedCalories(?float $estimatedCalories): static
    {
        $this->estimatedCalories = $estimatedCalories;

        return $this;
    }

    public function getEstimatedProteins(): ?float
    {
        return $this->estimatedProteins;
    }

    public function setEstimatedProteins(?float $estimatedProteins): static
    {
        $this->estimatedProteins = $estimatedProteins;

        return $this;
    }

    public function getEstimatedFats(): ?float
    {
        return $this->estimatedFats;
    }

    public function setEstimatedFats(?float $estimatedFats): static
    {
        $this->estimatedFats = $estimatedFats;

        return $this;
    }

    public function getEstimatedCarbs(): ?float
    {
        return $this->estimatedCarbs;
    }

    public function setEstimatedCarbs(?float $estimatedCarbs): static
    {
        $this->estimatedCarbs = $estimatedCarbs;

        return $this;
    }

    public function getMealSource(): ?string
    {
        return $this->mealSource;
    }

    public function setMealSource(string $mealSource): static
    {
        $this->mealSource = $mealSource;

        return $this;
    }

    public function getExternalName(): ?string
    {
        return $this->externalName;
    }

    public function setExternalName(?string $externalName): static
    {
        $this->externalName = $externalName;

        return $this;
    }
}

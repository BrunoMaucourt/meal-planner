<?php

namespace App\Entity\Recipe;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\Recipe\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $caloriesPer100g = null;

    #[ORM\Column(nullable: true)]
    private ?float $proteinsPer100g = null;

    #[ORM\Column(nullable: true)]
    private ?float $fatsPer100g = null;

    #[ORM\Column(nullable: true)]
    private ?float $carbsPer100g = null;

    #[ORM\Column(nullable: true)]
    private ?float $fibersPer100g = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dataSource = null;

    /**
     * @var Collection<int, RecipeIngredient>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngredient::class, mappedBy: 'ingredient', orphanRemoval: true)]
    private Collection $recipeIngredients;

    public function __construct()
    {
        $this->recipeIngredients = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCaloriesPer100g(): ?float
    {
        return $this->caloriesPer100g;
    }

    public function setCaloriesPer100g(?float $caloriesPer100g): static
    {
        $this->caloriesPer100g = $caloriesPer100g;

        return $this;
    }

    public function getProteinsPer100g(): ?float
    {
        return $this->proteinsPer100g;
    }

    public function setProteinsPer100g(?float $proteinsPer100g): static
    {
        $this->proteinsPer100g = $proteinsPer100g;

        return $this;
    }

    public function getFatsPer100g(): ?float
    {
        return $this->fatsPer100g;
    }

    public function setFatsPer100g(?float $fatsPer100g): static
    {
        $this->fatsPer100g = $fatsPer100g;

        return $this;
    }

    public function getCarbsPer100g(): ?float
    {
        return $this->carbsPer100g;
    }

    public function setCarbsPer100g(?float $carbsPer100g): static
    {
        $this->carbsPer100g = $carbsPer100g;

        return $this;
    }

    public function getFibersPer100g(): ?float
    {
        return $this->fibersPer100g;
    }

    public function setFibersPer100g(?float $fibersPer100g): static
    {
        $this->fibersPer100g = $fibersPer100g;

        return $this;
    }

    public function getDataSource(): ?string
    {
        return $this->dataSource;
    }

    public function setDataSource(?string $dataSource): static
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getIngredient() === $this) {
                $recipeIngredient->setIngredient(null);
            }
        }

        return $this;
    }
}

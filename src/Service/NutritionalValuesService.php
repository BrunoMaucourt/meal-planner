<?php

namespace App\Service;

use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeIngredient;
use App\Enum\UnitEnum;

class NutritionalValuesService
{
    public function getValuesForRecipe(Recipe $recipe): array
    {
        $nutritionalData = [
            'calories' => 0,
            'proteins' => 0,
            'fats' => 0,
            'carbs' => 0,
            'fibers' => 0
        ];
        $allRecipeIngredients = $recipe->getIngredients();

        foreach ($allRecipeIngredients as $recipeIngredient) {
            $ingredient = $recipeIngredient->getIngredient();
            $quantity = $this->getQuantityByGram($recipeIngredient);

            $nutritionalData['calories'] += $ingredient->getCaloriesPer100g() * $quantity / 100 / $recipe->getServings();
            $nutritionalData['proteins'] += $ingredient->getProteinsPer100g() * $quantity / 100 / $recipe->getServings();
            $nutritionalData['fats'] += $ingredient->getFatsPer100g() * $quantity / 100 / $recipe->getServings();
            $nutritionalData['carbs'] += $ingredient->getCarbsPer100g() * $quantity / 100 / $recipe->getServings();
            $nutritionalData['fibers'] += $ingredient->getFibersPer100g() * $quantity / 100 / $recipe->getServings();
        }

        return $nutritionalData;
    }

    private function getQuantityByGram (RecipeIngredient $recipeIngredient): float
    {
        dump($recipeIngredient->getUnit());
        $ingredientName = strtolower($recipeIngredient->getIngredient()->getName());
        $unit = $recipeIngredient->getUnit();
        $quantity = $recipeIngredient->getQuantity();

        $categories = [
            'flour' => ['flour', 'farine', 'starch', 'fécule'],
            'butter' => ['butter', 'beurre'],
            'cream' => ['cream', 'crème'],
            'sugar_salt' => ['sugar', 'sucre', 'salt', 'sel'],
            'liquid' => ['oil', 'huile', 'vinegar', 'vinaigre', 'water', 'eau', 'wine', 'vin', 'alcohol', 'alcool'],
        ];

        $weights = [
            UnitEnum::tablespoon->enumToString() => [
                'flour' => 10,
                'butter' => 10,
                'cream' => 10,
                'sugar_salt' => 12,
                'liquid' => 10,
                'default' => 10,
            ],
            UnitEnum::teaspoon->enumToString() => [
                'flour' => 3,
                'butter' => 4,
                'cream' => 5,
                'sugar_salt' => 5,
                'liquid' => 5,
                'default' => 5,
            ],
        ];

        if (in_array($unit, [UnitEnum::gram, UnitEnum::milliliter])) {
            return $quantity;
        }
        if ($unit === UnitEnum::tablespoon || $unit === UnitEnum::teaspoon) {
            $category = $this->detectCategory($ingredientName, $categories);
            $weightPerUnit = $weights[$unit->enumToString()][$category] ?? $weights[$unit->enumToString()]['default'];

            return $quantity * $weightPerUnit;
        }

        if ($unit === UnitEnum::pinch) {
            return 4 * $quantity;
        }

        if ($unit === UnitEnum::piece) {
            return 100 * $quantity;
        }

        return $quantity;
    }

    private function detectCategory(string $name, array $categories): string
    {
        foreach ($categories as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($name, $keyword)) {

                    return $category;
                }
            }
        }

        return 'default';
    }
}
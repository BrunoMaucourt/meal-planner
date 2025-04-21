<?php

namespace App\DataFixtures;

use App\Entity\Recipe\Ingredient;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeIngredient;
use App\Entity\Recipe\RecipeStep;
use App\Entity\Recipe\Utensil;
use App\Enum\MealTypeEnum;
use App\Enum\UnitEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class RecipeFixtureEN extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['en'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->getUtensilsFixtures($manager);
        $this->getRecipesFixture($manager);

        $manager->flush();
    }

    private function getUtensilsFixtures(ObjectManager $manager): void
    {
        $utensilsData = [
            'Knife',
            'Cutting board',
            'Saucepan',
            'Frying pan',
            'Pot',
            'Mixing bowl',
            'Whisk',
            'Wooden spoon',
            'Spatula',
            'Grater',
            'Peeler',
            'Measuring cup',
            'Measuring spoon',
            'Baking tray',
            'Colander',
            'Oven mitt',
            'Rolling pin',
            'Ladle',
            'Tongs',
            'Blender',
        ];

        foreach ($utensilsData as $utensilData) {
            $utensil = new Utensil();
            $utensil->setName($utensilData);
            $manager->persist($utensil);
        }
    }

    private function getRecipesFixture(ObjectManager $manager): void
    {
        /**
         * Recipe from
         * https://cuisine.journaldesfemmes.fr/recette/3132360-tofu-et-poivrons-marines-au-miel
         */
        $tofu = new Ingredient();
        $tofu->setName('Firm tofu');
        $tofu->setType('Protein');
        $manager->persist($tofu);

        $greenPepper = new Ingredient();
        $greenPepper->setName('Green bell pepper');
        $greenPepper->setType('Vegetable');
        $manager->persist($greenPepper);

        $honey = new Ingredient();
        $honey->setName('Honey');
        $honey->setType('Sweetener');
        $manager->persist($honey);

        $soySauce = new Ingredient();
        $soySauce->setName('Soy sauce');
        $soySauce->setType('Sauce');
        $manager->persist($soySauce);

        $sesameOil = new Ingredient();
        $sesameOil->setName('Sesame oil');
        $sesameOil->setType('Oil');
        $manager->persist($sesameOil);

        $riceVinegar = new Ingredient();
        $riceVinegar->setName('Rice vinegar');
        $riceVinegar->setType('');
        $manager->persist($riceVinegar);

        $recipe = new Recipe();
        $recipe->setName('Oven-Baked Tofu with Green Peppers');
        $recipe->setDescription('A simple and flavorful baked tofu dish with green peppers, marinated in a sweet and savory sauce.');
        $recipe->setServings(2);
        $recipe->setPreparationTime(10);
        $recipe->setCookingTime(40);
        $recipe->setDifficulty(1);
        $recipe->setType(MealTypeEnum::vegetarian);

        $manager->persist($recipe);

        $ingredients = [
            [$tofu, 250, UnitEnum::gram],
            [$greenPepper, 2, UnitEnum::piece],
            [$honey, 60, UnitEnum::milliliter],
            [$soySauce, 60, UnitEnum::milliliter],
            [$sesameOil, 30, UnitEnum::milliliter],
            [$riceVinegar, 30, UnitEnum::milliliter],
        ];

        foreach ($ingredients as [$ingredient, $quantity, $unit]) {
            $ri = new RecipeIngredient();
            $ri->setRecipe($recipe);
            $ri->setIngredient($ingredient);
            $ri->setQuantity($quantity);
            $ri->setUnit($unit);
            $manager->persist($ri);
        }

        $steps = [
            'Place tofu and diced green peppers in a large airtight container.',
            'Mix all marinade ingredients in a bowl. Pour over tofu and peppers, shake to coat well. Refrigerate for at least 2h or overnight.',
            'Preheat oven to 180°C. Transfer all contents to a baking dish in a single layer. Bake for 40 minutes. Serve hot with rice or bulgur.',
        ];

        foreach ($steps as $i => $text) {
            $step = new RecipeStep();
            $step->setRecipe($recipe);
            $step->setStepOrder($i + 1);
            $step->setInstruction($text);
            $manager->persist($step);
        }
    }
}
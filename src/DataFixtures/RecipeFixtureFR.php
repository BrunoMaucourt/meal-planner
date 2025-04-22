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
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class RecipeFixtureFR extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ){
    }

    public static function getGroups(): array
    {
        return ['fr'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->getUtensilsFixtures($manager);
        $this->getIngredientsFixtures($manager);
        $this->getRecipesFixture($manager);
    }

    private function getUtensilsFixtures(ObjectManager $manager): void
    {
        $utensilsData = [
            'Couteau',
            'Planche à découper',
            'Casserole',
            'Poêle',
            'Marmite',
            'Saladier',
            'Fouet',
            'Cuillère en bois',
            'Spatule',
            'Râpe',
            'Éplucheur',
            'Tasse à mesurer',
            'Cuillère à mesurer',
            'Plaque de cuisson',
            'Passoire',
            'Four',
            'Gant de four',
            'Rouleau à pâtisserie',
            'Louche',
            'Pince de cuisine',
            'Mixeur',
        ];

        foreach ($utensilsData as $utensilData) {
            $utensil = new Utensil();
            $utensil->setName($utensilData);
            $manager->persist($utensil);
        }

        $manager->flush();
    }

    private function getIngredientsFixtures(ObjectManager $manager): void
    {
        /**
         * Table de composition nutritionnelle des aliments Ciqual
         * 3 juillet 2020
         * Licence Ouverte
         * https://www.data.gouv.fr/en/datasets/table-de-composition-nutritionnelle-des-aliments-ciqual/
         */
        $inputFileName = './public/nutritionalData/Table_Ciqual_2020_FR_2020_07_07.xls';
        $reader = new Xls();
        $spreadsheet = $reader->load($inputFileName);
        $spreadsheetAsArray = $spreadsheet->getActiveSheet()->toArray();

        foreach ($spreadsheetAsArray as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row[7]);
            $ingredient->setDataSource('Table de composition nutritionnelle des aliments Ciqual 2020');

            if (
                !is_null($row[5]) &&
                $row != '-'
            ) {
                $ingredient->setType($row[5]);
            } else {
                $ingredient->setType('none');
            }

            $columnMap = [
                'setCaloriesPer100g' => 10,
                'setProteinsPer100g' => 14,
                'setCarbsPer100g' => 16,
                'setFatsPer100g' => 17,
                'setFibersPer100g' => 26,
            ];

            foreach ($columnMap as $setter => $index) {
                $value = $row[$index] ?? null;
                $ingredient->$setter((float)$value);
            }

            $manager->persist($ingredient);
        }

        $manager->flush();
    }

    private function getRecipesFixture(ObjectManager $manager): void
    {
        /**
         * Recipe from
         * https://cuisine.journaldesfemmes.fr/recette/3132360-tofu-et-poivrons-marines-au-miel
         */

        $ingredientRepo = $manager->getRepository(Ingredient::class);
        $utensilRepo = $manager->getRepository(Utensil::class);

        $rice = $ingredientRepo->findOneBy(['name' => 'Riz complet, cuit, non salé']);
        $tofu = $ingredientRepo->findOneBy(['name' => 'Tofu nature, préemballé']);
        $greenPepper = $ingredientRepo->findOneBy(['name' => 'Poivron vert, cru']);
        $honey = $ingredientRepo->findOneBy(['name' => 'Miel']);
        $soySauce = $ingredientRepo->findOneBy(['name' => 'Sauce soja, préemballée']);
        $sesameOil = $ingredientRepo->findOneBy(['name' => 'Huile de sésame']);

        $riceVinegar = new Ingredient();
        $riceVinegar->setName('Vinaigre de riz');
        $riceVinegar->setType('');
        $manager->persist($riceVinegar);

        $recipe = new Recipe();
        $recipe->setName('Tofu et poivrons marinés au miel');
        $recipe->setDescription('Une recette adaptée de la viande laquée à la chinoise, mais en version végétarienne, légère et craquante.');
        $recipe->setServings(2);
        $recipe->setPreparationTime(10);
        $recipe->setCookingTime(40);
        $recipe->setDifficulty(1);
        $recipe->setType(MealTypeEnum::vegetarian);
        $recipe->addUtensil($utensilRepo->findOneBy(['name' => 'Couteau']));
        $recipe->addUtensil($utensilRepo->findOneBy(['name' => 'Planche à découper']));
        $recipe->addUtensil($utensilRepo->findOneBy(['name' => 'Four']));
        $recipe->addUtensil($utensilRepo->findOneBy(['name' => 'Gant de four']));

        $manager->persist($recipe);

        $ingredients = [
            [$rice, 300, UnitEnum::gram],
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
            'Placer le tofu et le poivrons en dés dans une grande boîte hermétique. Bien mélanger dans un bol tous les ingrédients de la marinade, la verser sur le tofu et poivrons, puis fermer la boîte, le secouer pour bien répartir la marinade, et réfrigérer pendant 2h minimum (ou jusqu\'à une nuit).',
            'Préchauffer le four à 180°C. Verser l’ensemble du contenu de la boîte hermétique (tofu, poivrons et marinade) dans un plat allant au four (en une couche dans la mesure du possible), puis enfourner pendant 40 minutes . Servir chaud, avec du riz ou du boulgour par exemple.',
        ];

        foreach ($steps as $i => $text) {
            $step = new RecipeStep();
            $step->setRecipe($recipe);
            $step->setStepOrder($i + 1);
            $step->setInstruction($text);
            $manager->persist($step);
        }

        $manager->flush();
    }
}
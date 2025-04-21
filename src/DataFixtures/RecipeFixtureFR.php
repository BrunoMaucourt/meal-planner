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
use Doctrine\Persistence\ObjectManager;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class RecipeFixtureFR extends Fixture
{
    public static function getGroups(): array
    {
        return ['fr'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->getUtensilsFixtures($manager);
        $this->getIngredientsFixtures($manager);

        $manager->flush();
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
    }
}
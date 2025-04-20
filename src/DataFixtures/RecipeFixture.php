<?php

namespace App\DataFixtures;

use App\Entity\Recipe\Utensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
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

        $manager->flush();
    }
}
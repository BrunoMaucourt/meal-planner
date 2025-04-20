<?php

namespace App\Controller\Admin;

use App\Entity\Recipe\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;

class IngredientCrudController extends AbstractCrudController
{
    public function __construct(
        private TranslatorInterface $translator,
    ){
    }

    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', $this->translator->trans('Name'))
            ->setColumns(6)
        ;

        yield TextField::new('type', $this->translator->trans('Type'))
            ->setColumns(6)
        ;

        yield FormField::addPanel('Nutritional Values');

        yield NumberField::new('caloriesPer100g', $this->translator->trans('Calories per 100g'))
            ->setColumns(4)
        ;

        yield NumberField::new('proteinsPer100g', $this->translator->trans('Proteins per 100g'))
            ->setColumns(4)
        ;

        yield NumberField::new('carbsPer100g', $this->translator->trans('Carbs per 100g'))
            ->setColumns(4)
        ;

        yield NumberField::new('fatsPer100g', $this->translator->trans('Fats per 100g'))
            ->setColumns(4)
        ;

        yield NumberField::new('fibersPer100g', $this->translator->trans('Fibers per 100g'))
            ->setColumns(4)
        ;

        yield TextField::new('dataSource', $this->translator->trans('Data source'))
            ->setColumns(4)
        ;
    }
}

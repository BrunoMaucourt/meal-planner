<?php

namespace App\Controller\Admin;

use App\EasyAdmin\DifficultyField;
use App\EasyAdmin\UnitField;
use App\Entity\Recipe\RecipeIngredient;
use App\Enum\MealTypeEnum;
use App\Enum\UnitEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;

class RecipeIngredientCrudController extends AbstractCrudController
{
    public function __construct(
        private TranslatorInterface $translator,
    ){
    }

    public static function getEntityFqcn(): string
    {
        return RecipeIngredient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('ingredient', $this->translator->trans('Ingredient'))
            ->setColumns(4)
        ;

        yield NumberField::new('quantity', $this->translator->trans('Quantity'))
            ->setColumns(4)
        ;

        yield UnitField::new('unit', $this->translator->trans('Unit'))
            ->formatValue(static function (?UnitEnum $unitEnum): string {
                return $unitEnum?->enumToString() ?? '';
            })
            ->setColumns(4)
        ;
    }
}

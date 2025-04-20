<?php

namespace App\Controller\Admin;

use App\Entity\Recipe\RecipeIngredient;
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

        yield TextField::new('unit', $this->translator->trans('Unit'))
            ->setColumns(4)
        ;
    }
}

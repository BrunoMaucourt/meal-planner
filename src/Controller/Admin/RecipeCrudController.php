<?php

namespace App\Controller\Admin;

use App\EasyAdmin\DifficultyField;
use App\Entity\Recipe\Recipe;
use App\Enum\MealTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Contracts\Translation\TranslatorInterface;

class RecipeCrudController extends AbstractCrudController
{
    public function __construct(
        private TranslatorInterface $translator,
    ){
    }

    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', $this->translator->trans('Name'))
            ->setColumns(4)
        ;

        yield TextField::new('type', $this->translator->trans('Type'))
            ->setColumns(4)
        ;

        yield CountryField::new('origin', $this->translator->trans('Origin'))
            ->setColumns(4)
        ;

        yield TimeField::new('cooking_time', $this->translator->trans('Cooking time'))
            ->setColumns(3)
        ;

        yield TimeField::new('preparation_time', $this->translator->trans('Preparation time'))
            ->setColumns(3)
        ;

        yield IntegerField::new('servings', $this->translator->trans('Servings'))
            ->setColumns(3)
        ;

        yield IntegerField::new('difficulty', $this->translator->trans('Difficulty'))
            ->setColumns(3)
        ;

        yield TextEditorField::new('description', $this->translator->trans('Description'))
            ->setColumns(12)
        ;

        yield CollectionField::new('steps', $this->translator->trans('Recipe steps'))
            ->setColumns(12)
            ->useEntryCrudForm(RecipeStepCrudController::class)
        ;

        yield CollectionField::new('Ingredients', $this->translator->trans('Recipe ingredients'))
            ->setColumns(12)
            ->useEntryCrudForm(RecipeIngredientCrudController::class)
        ;

        yield CollectionField::new('utensils', $this->translator->trans('Recipe utensils'))
            ->setColumns(12)
            ->useEntryCrudForm(UtensilCrudController::class)
        ;
    }
}

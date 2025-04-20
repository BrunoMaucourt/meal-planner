<?php

namespace App\Controller\Admin;

use App\Entity\Recipe\RecipeStep;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;

class RecipeStepCrudController extends AbstractCrudController
{
    public function __construct(
        private TranslatorInterface $translator,
    ){
    }

    public static function getEntityFqcn(): string
    {
        return RecipeStep::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('stepOrder', $this->translator->trans('Step number'))
            ->setColumns(4)
        ;

        yield TextEditorField::new('instruction', $this->translator->trans('Instruction'))
            ->setColumns(12)
        ;
    }
}

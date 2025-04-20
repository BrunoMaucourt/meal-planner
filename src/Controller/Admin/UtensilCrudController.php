<?php

namespace App\Controller\Admin;

use App\Entity\Recipe\Utensil;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;

class UtensilCrudController extends AbstractCrudController
{
    public function __construct(
        private TranslatorInterface $translator,
    ){
    }

    public static function getEntityFqcn(): string
    {
        return Utensil::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', $this->translator->trans('Name'))
            ->setColumns(4)
        ;
    }
}

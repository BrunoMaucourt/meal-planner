<?php

namespace App\Controller\Admin;

use App\Entity\Planning\Meal;
use App\Entity\Recipe\Ingredient;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeIngredient;
use App\Entity\Recipe\RecipeStep;
use App\Entity\Recipe\Utensil;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
    ){
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $recipesCount = $this->entityManager->getRepository(Recipe::class)->count([]);

         return $this->render('admin/dashboard.html.twig', [
             'recipesCount' => $recipesCount,
         ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Meal Planner')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Recipe');
        yield MenuItem::linkToCrud($this->translator->trans('Recipe'), 'fa-solid fa-book', Recipe::class);
        yield MenuItem::linkToCrud($this->translator->trans('Recipe steps'), 'fa-solid fa-list-ol', RecipeStep::class);
        yield MenuItem::linkToCrud($this->translator->trans('Ingredients'), 'fa-solid fa-carrot', Ingredient::class);
        yield MenuItem::linkToCrud($this->translator->trans('Ingredients - recipe'), 'fa-solid fa-burger', RecipeIngredient::class);
        yield MenuItem::linkToCrud($this->translator->trans('Utensils'), 'fa-solid fa-utensils', Utensil::class);
        yield MenuItem::section('Meal');
        yield MenuItem::linkToCrud($this->translator->trans('Meal'), 'fa-solid fa-calendar-days', Meal::class);
        yield MenuItem::section('User');
        yield MenuItem::linkToCrud($this->translator->trans('User'), 'fa-solid fa-utensils', User::class);
    }
}

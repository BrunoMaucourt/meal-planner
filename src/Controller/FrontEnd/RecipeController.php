<?php

namespace App\Controller\FrontEnd;

use App\Entity\Recipe\Recipe;
use App\Repository\Recipe\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/recipes', name: 'recipe_index')]
    public function index(RecipeRepository $repo): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipes' => $repo->findAll(),
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/recipes/{id}', name: 'recipe_show')]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
<?php

namespace App\Controller\FrontEnd;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/')]
    public function redirectToLocale(Request $request): RedirectResponse
    {
        $locale = $request->getPreferredLanguage(['fr', 'en']) ?? 'en';
        return $this->redirectToRoute('homepage', ['_locale' => $locale]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('homepage.html.twig');
    }
}
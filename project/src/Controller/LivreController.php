<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreController extends AbstractController
{
    #[Route('/nos-livres', name: 'app_livre')]
    public function index(LivreRepository $livreRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $livres = $livreRepository->findAll();

        $livresWithPaginator = $paginator->paginate(
            $livres,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('livre/index.html.twig', [
            'livres' => $livresWithPaginator,
        ]);
    }

    #[Route('/nos-livres/{id}', name: 'app_livre_show')]
    public function show($id, LivreRepository $livreRepository): Response
    {
        $livre = $livreRepository->find($id);

        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }
}

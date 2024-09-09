<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use App\Form\LivreType;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/library/add', name: 'app_library_add')]
    public function addBook(): Response
    {
        $livre = new Livre();

        $form = $this->createForm(LivreType::class, $livre);

        return $this->render('library/addBook.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

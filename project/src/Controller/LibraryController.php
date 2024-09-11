<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\Langue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use App\Form\AuteurType;
use App\Form\EditeurType;
use App\Form\GenreType;
use App\Form\LangueType;
use App\Form\LivreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig');
    }

    #[Route('/library/add', name: 'app_library_add')]
    public function addBook(Request $request, EntityManagerInterface $em): Response
    {
        $livre = new Livre();

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($livre);
            $em->flush();
            $this->addFlash('livre', 'Votre livre a bien été ajouté à votre bibliothèque');
            return $this->redirectToRoute('app_library');
        }

        $langue = new Langue();
        $langue_form = $this->createForm(LangueType::class, $langue);
        $langue_form->handleRequest($request);

        if ($langue_form->isSubmitted() && $langue_form->isValid()){
            $em->persist($langue);
            $em->flush();
            return $this->redirectToRoute('app_library_add');
        }

        $genre = new Genre();
        $genre_form = $this->createForm(GenreType::class, $genre);
        $genre_form->handleRequest($request);

        if ($genre_form->isSubmitted() && $genre_form->isValid()){
            $em->persist($genre);
            $em->flush();
            return $this->redirectToRoute('app_library_add');
        }

        $editeur = new Editeur();
        $editeur_form = $this->createForm(EditeurType::class, $editeur);
        $editeur_form->handleRequest($request);

        if ($editeur_form->isSubmitted() && $editeur_form->isValid()) {
            $em->persist($editeur);
            $em->flush();
            return $this->redirectToRoute('app_library_add');
        }

        $auteur = new Auteur();
        $auteur_form = $this->createForm(AuteurType::class, $auteur);
        $auteur_form->handleRequest($request);

        if ($auteur_form->isSubmitted() && $auteur_form->isValid()) {
            $em->persist($auteur);
            $em->flush();
            return $this->redirectToRoute('app_library_add');
        }
        

        return $this->render('library/addBook.html.twig', [
            'form' => $form->createView(),
            'langue_form' => $langue_form->createView(),
            'genre_form' => $genre_form->createView(),
            'editeur_form' => $editeur_form->createView(),
            'auteur_form' => $auteur_form->createView(),
        ]);
    }
    
}

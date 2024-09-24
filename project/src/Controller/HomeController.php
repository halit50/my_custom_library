<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app.home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nom = $form->getData()['nom'];
            $email = $form->getData()['email'];
            $numero = $form->getData()['numero'];
            $message = $form->getData()['message'];
            $objet = $form->getData()['objet'];

            //dd($form->getData());

            $mail = (new Email())
            ->from($email)
            ->to('bruppaulujeda-1936@yopmail.com')
            ->subject($objet)
            ->text($message);

    

            try {
               
                $mailer->send($mail);
            
            } catch (\Exception $e) {
                // En cas d'erreur, affichez le message pour investiguer.
                dd($e->getMessage());
            }

            return $this->redirectToRoute('app.home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
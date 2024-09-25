<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
            $mailFrom= $this->getParameter('mail_from');
            $mailTo = $this->getParameter('mail_to');


            $mail = (new TemplatedEmail())
            ->from($mailFrom)
            ->to($mailTo)
            ->replyTo($email)
            ->subject($objet)
            ->htmlTemplate('email/email.html.twig')
            ->context([
                'nom' => $nom,
                'mail' => $email,
                'numero' => $numero,
               'message' => $message,
            ]);

            try {
               
                $mailer->send($mail);
                $this->addFlash('success','Votre email a bien été envoyé');
            
            } catch (\Exception $e) {
                // En cas d'erreur, affichez le message pour investiguer.
                $this->addFlash('notsuccess',"Votre email n'a pas pu être envoyé, veuillez réessayer ultérieurement s'il vous plait");
                dd($e->getMessage());
            }

            return $this->redirectToRoute('app.home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
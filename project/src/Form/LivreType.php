<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Langue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Range;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('imageFile', VichImageType::class)
            ->add('description', TextareaType::class)
            ->add('langue', EntityType::class, [
                'class' => Langue::class,
                'choice_label' => 'nom',
                'placeholder' => "Veuillez choisir une langue (l'ajouter si elle n'est pas dans la liste)",
                'required' => true
            ])
            ->add('date_parution', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('nombre_pages', IntegerType::class, [
                'attr' => [
                    'min' => 1
                ],
            'constraints' => [
                new Range([
                    'min' => 0,
                    'minMessage' => 'Le nombre ne peut pas être négatif.',
                ]),
            ],
            ])
            ->add('genre_id', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'label' => 'Genre',
                'placeholder' => "Veuillez choisir un genre (l'ajouter si il n'est pas dans la liste)",
                'required' => true
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => function(Auteur $auteur) {
                return $auteur->getPrenom() . ' ' . $auteur->getNom();},
                'multiple' => true,
                'placeholder' => "Veuillez choisir un ou les auteurs (ajouter les si ils ne sont pas dans la liste)",
                'required' => true
            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nom',
                'placeholder' => "Veuillez choisir un éditeur (l'ajouter si il n'est pas dans la liste)",
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter'        
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}

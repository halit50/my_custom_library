<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Langue;
use phpDocumentor\Reflection\Types\Integer;
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
            ])
            ->add('date_parution', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('nombre_pages', IntegerType::class)
            ->add('genre_id', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'label' => 'Genre'
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'nom prenom',
                'multiple' => true,
            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nom',
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

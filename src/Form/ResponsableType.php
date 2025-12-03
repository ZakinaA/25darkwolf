<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Responsable;
use App\Entity\Tranche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('numRue')
            ->add('rue')
            ->add('copos')
            ->add('ville')
            ->add('tel')
            ->add('mail')
            ->add('eleves', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => function(Eleve $e) {
                    return $e->getPrenom() . ' ' . $e->getNom();
                },
                'multiple' => true,
            ])
            ->add('tranche', EntityType::class, [
                'class' => Tranche::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}

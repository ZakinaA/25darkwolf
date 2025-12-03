<?php

namespace App\Form;

use App\Entity\ContratPret;
use App\Entity\Intervention;
use App\Entity\Professionnel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('descriptif')
            ->add('prix')
            ->add('quotite')
            ->add('professionnel', EntityType::class, [
                'class' => Professionnel::class,
                'choice_label' => 'nom',
            ])
            ->add('contratPret', EntityType::class, [
                'class' => ContratPret::class,
                'choice_label' => 'num_contrat',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Paiement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('datePaiement')
            ->add('inscription', EntityType::class, [
                    'class' => Inscription::class,
                    'choice_label' => function(Inscription $i) {
                        $eleve = $i->getEleve();
                        $cours = $i->getCours();
                        return ($eleve ? $eleve->getPrenom() . ' ' . $eleve->getNom() : 'Élève inconnu') 
                            . ' - ' 
                            . ($cours ? $cours->getLibelle() : 'Cours inconnu');
                    },
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}

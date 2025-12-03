<?php

namespace App\Form;

use App\Entity\ContratPret;
use App\Entity\Eleve;
use App\Entity\Intervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratPretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numContrat', TextType::class, [
                'label' => 'Numéro de Contrat',
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de Début',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de Fin',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('attestationAssurance', CheckboxType::class, [
                'label' => 'Attestation d\'Assurance Fournie',
                'required' => false,
            ])
            ->add('etatDetailleDebut', TextareaType::class, [
                'label' => 'État détaillé au début du prêt',
                'required' => false,
            ])
            ->add('etatDetailleRetour', TextareaType::class, [
                'label' => 'État détaillé au retour du prêt',
                'required' => false,
            ])
            ->add('eleve', EntityType::class, [
    'class' => Eleve::class,
    'choice_label' => function(Eleve $e) {
        return $e->getPrenom() . ' ' . $e->getNom();
    },
    'label' => 'Élève Emprunteur',
])
            // Note: interventions n'est pas ajouté au formulaire car c'est une collection (OneToMany) 
            // gérée par Doctrine et potentiellement par un formulaire imbriqué si nécessaire, 
            // mais pas directement pour la création simple.
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContratPret::class,
        ]);
    }
}

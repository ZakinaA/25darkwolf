<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\Instrument;
use App\Entity\Marque;
use App\Entity\TypeInstrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // <-- IMPORTANT : Ajouter ce "use"
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSerie')
            ->add('dateAchat')
            ->add('prixAchat')
            ->add('utilisation')
            ->add('cheminImage')

            // --- CORRECTION POUR TypeInstrument ---
            ->add('typeInstrument', EntityType::class, [
                // Spécifie à quelle entité ce champ est lié
                'class' => TypeInstrument::class,

                // C'est la clé ! On dit à Symfony d'utiliser la propriété 'libelle' pour l'affichage
                'choice_label' => 'libelle',

                // Ajoute un libellé clair au-dessus du champ
                'label' => 'Type d\'instrument'
            ])

            // --- CORRECTION POUR Couleurs ---
            ->add('couleurs', EntityType::class, [
                'class' => Couleur::class,
                // On utilise la propriété 'nom' de l'entité Couleur
                'choice_label' => 'nom',

                // Comme un instrument peut avoir plusieurs couleurs, on autorise la sélection multiple
                'multiple' => true,
                
                // Optionnel : 'expanded' => true, affichera des cases à cocher au lieu d'une liste
                // 'expanded' => true,
            ])

            // --- CORRECTION POUR Marque ---
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                // On utilise la propriété 'libelle' de l'entité Marque
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
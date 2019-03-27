<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\OffreStage;
use App\Entity\Societe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')

            ->add('domaine', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir domaines',
                'multiple'=> false,
                'expanded'=> true
            ))
            ->add('societe', EntityType::class, array(
                'class'=> Societe::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir societe'
            ))
            ->add('description')

            ->add('dateDebut')
            ->add('dateFin')
            ->add('domaine', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreStage::class,
        ]);
    }
    public function getBlockPrefix()
    {
        return null;
    }
}

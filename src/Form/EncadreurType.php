<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Encadreur;
use App\Entity\Universite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncadreurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin')
            ->add('domaine', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir domaines',
            ))
            ->add('universite',EntityType::class ,array(
                'class'=> Universite::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir universite',
            ))
            ->add('utilisateur', UtilisateurType::class, array(
                'label'=> false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Encadreur::class,
        ]);
    }
}

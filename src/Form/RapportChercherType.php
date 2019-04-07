<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Universite;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportChercherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'required'=> false
            ))


            ->add('domaine', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir domaine',
                'multiple'=> false,
                'required'=> false
            ))
            ->add('universite',EntityType::class ,array(
                'class'=> Universite::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir universite','required'=> false))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}

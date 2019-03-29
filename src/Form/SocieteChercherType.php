<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteChercherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'required'=> false
            ))
            ->add('ville', EntityType::class, array(
                'required'=> false,
                'class'=> Ville::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir ville'
            ))
            ->add('domaine', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir domaine',
                'multiple'=> false,
                'required'=> false
            ))
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

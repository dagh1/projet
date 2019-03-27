<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Societe;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('ville', EntityType::class, array(
                'class'=> Ville::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir ville'
            ))
            ->add('email')
            ->add('siteWeb')
            ->add('telephone')
            ->add('description')
            ->add('domaines', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir domaines',
                'multiple'=> true,
                'expanded'=> true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}

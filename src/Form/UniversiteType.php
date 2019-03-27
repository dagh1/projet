<?php

namespace App\Form;

use App\Entity\Universite;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniversiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('email')
            ->add('siteWeb')
            ->add('telephone')
            ->add('adresse')
            ->add('ville' ,EntityType::class, array(
        'class'=> Ville::class,
        'choice_label'=> 'nom',
        'placeholder'=> 'Choisir ville'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Universite::class,
        ]);
    }
}

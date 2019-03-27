<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Rapport;
use App\Entity\Universite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('domaine', EntityType::class, array(
                'class'=> Domaine::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir domaines',
                'expanded'=> true
            ))
            ->add('universite',EntityType::class ,array(
                'class'=> Universite::class,
                'choice_label'=> 'nom',
                'placeholder'=> 'Choisir universite',
            ))
            ->add('file', FileType::class, array(
                'label'=> 'Choisisez un fichier',
                'attr'=> array(
                    'class'=> 'form-control'
                ),
                'required'=> is_null($builder->getData()->getId())
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}

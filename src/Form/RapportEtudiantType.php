<?php

namespace App\Form;

use App\Entity\RapportEtudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
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
            'data_class' => RapportEtudiant::class,
        ]);
    }
}

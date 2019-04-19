<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet')
            ->add('description', TextareaType::class, array(
                'label'=> 'Déscription',
                'attr'=> array(
                    'rows'=>7
                )
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
            'data_class' => Projet::class,
        ]);
    }
}

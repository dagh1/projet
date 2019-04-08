<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'required'=> false
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom',
            ))
           /* ->add('gender', ChoiceType::class, array(
                'label' => 'Sexe',
                'required'=> false,
                'choices' => array(
                    'Homme' => 'man',
                    'Femme' => 'woman'
                ),
                'placeholder' => 'Non précisé',
            ))
            ->add('birthDate', BirthdayType::class, array(
                'label' => 'Date de Naissance',
                'placeholder' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y'), date('Y') - 70),
            ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'data_class' => Utilisateur::class,
        ));
    }


    public function getBlockPrefix(): ?string
    {
        return null;
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
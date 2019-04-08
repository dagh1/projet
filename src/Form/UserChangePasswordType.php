<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserChangePasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, array(
                'label'=> 'Ancien mot de passe',
                'mapped'=> false,
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'mapped'=> false,
                'type' => PasswordType::class,
                'first_options'  => array(
                    'label' => 'Nouveau mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Mot de passe ne doit pas être vide',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Mot de passe doit avoir au minimum {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ),
                'second_options' => array('label' => 'Confirmation'),
                'invalid_message' => 'Les deux mots de passe ne sont pas identiques',
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Utilisateur::class,
            'validation_groups'=> array("change_password")
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_user_change_password';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
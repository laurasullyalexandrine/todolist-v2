<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur"
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'utilisateur' => "ROLE_USER",
                    'administrateur' => "ROLE_ADMIN",
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Rôle de l\'utilisateur *',
                'constraints' => [
                    new NotBlank,
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe ',
                ],
                'second_options' => [
                    'label' => 'Tapez le mot de passe à nouveau',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

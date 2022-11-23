<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class, [
            'label' => 'Nom'
        ])
        ->add('firstname', TextType::class, [
            'label' => 'Prénom'
        ])
        ->add('phone', TextType::class, [
            'label' => 'Numéro de téléphone'
        ])
        ->add('adress', TextType::class, [
            'label' => 'Adresse'
        ])
        ->add('roles', ChoiceType::class, [
            'choices' => [
                "Utilisateur" => 'ROLE_USER',
                "Administrateur" => 'ROLE_ADMIN'
            ],
            'multiple' => true,
            'label' => 'Roles'
        ])
        ->add('email', EmailType::class, [
            'label' => 'Adresse email'
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Mot de passe'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
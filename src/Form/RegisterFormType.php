<?php

declare(strict_types = 1);

namespace Mact\Form;

use Mact\Entity\User;
use Mact\Validator\Constraints\Password;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label'              => 'mact._form.login.lastname',
                'translation_domain' => 'mact',
                'required'           => true,
                'constraints'        => [
                    new NotBlank(),
                    new Length(
                        min: 3,
                        max: 255,
                        minMessage: 'mact._form._error.min_character'
                    ),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label'              => 'mact._form.login.firstname',
                'translation_domain' => 'mact',
                'required'           => true,
                'constraints'        => [
                    new NotBlank(),
                    new Length(
                        min: 3,
                        max: 255,
                        minMessage: 'mact._form._error.min_character'
                    ),
                ],
            ])
            ->add('email', EmailType::class, [
                'label'              => 'mact._form.login.email',
                'translation_domain' => 'mact',
                'required'           => true,
                'constraints'        => [
                    new NotBlank(),
                    new Email(message: 'mact._form._error.email'),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required'      => true,
                'mapped'        => false,
                'type'          => PasswordType::class,
                'first_options' => [
                    'label'              => 'mact._form.login.password',
                    'translation_domain' => 'mact',
                    'constraints'        => [
                        new NotBlank(
                            message: 'mact._form._error.not_blank',
                        ),
                        new Length(
                            min: 3,
                            max: 255,
                            minMessage: 'mact._form._error.min_character'
                        ),
                    ],
                ],
                'second_options' => [
                    'label'              => 'mact._form.login.password_repeat',
                    'translation_domain' => 'mact',
                    'constraints'        => [
                        new NotBlank(
                            message: 'mact._form._error.not_blank',
                        ),
                        new Length(
                            min: 3,
                            max: 255,
                            minMessage: 'mact._form._error.min_character'
                        ),
                    ],
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'mact._form._error.not_blank',
                    ),
                    new Password(maxChar: 20),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped'             => false,
                'label'              => 'mact._form.login.agree_terms',
                'translation_domain' => 'mact',
                'constraints'        => [
                    new IsTrue(
                        message: 'mact._form._error.agree_terms',
                    ),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

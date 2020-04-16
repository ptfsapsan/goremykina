<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите пожалуйста email'
                    ]),
                ],
                'trim' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите пожалуйста пароль'
                    ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Пароль не должен быть длинее {{ limit }} символов.'
                    ]),
                ],
                'trim' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить',
                'attr' => [
                    'class' => 'button',
                ],
            ])
        ;
        $email = $builder->get('email');
        $builder->add($email);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_csrf_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id' => 'authenticate',
            'mapped' => false,

        ]);
    }
}

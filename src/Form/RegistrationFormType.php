<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = $this->getParent('security.role_hierarchy.roles');
        $builder

            ->add('roles', ChoiceType::class,array(
                'attr'  =>  array('class' => 'container-fluid',
                'style' => 'border:none;width:fit-content;background-color:transparent;',),
                'choices'   => array
                (
                
                'Choix de votre rôle :' => array
                (
                    'Acheteur' => 'ROLE_ACHETEUR',
                    'Vendeur' => 'ROLE_VENDEUR'
                ),
                
                ) ,
                'required' => true,
                'expanded' =>true,
                'multiple'  => true,
            )
        
            )
            ->add('email', EmailType::class,
                [
                    'constraints' => [
                        new NotBlank([
                        'message' => 'Merci d\'entrer votre adresse email',
                        ]),    
                ],
            ])
            ->add('prenom', TextType::class,
            [
                'constraints' => [
                    new NotBlank([
                    'message' => 'Merci d\'entrer votre prénom',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
            ],
        ])
            ->add('nom',TextType::class,
            [
                'constraints' => [
                    new NotBlank([
                    'message' => 'Merci d\'entrer votre nom',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
            ],
        ])
            ->add('numero_telephone',TelType::class,
            [
                'constraints' => [
                    new NotBlank([
                    'message' => 'Merci d\'entrer votre numéro de téléphone',
                    ]),
                    new Length([
                        'min' => 10,
                        'maxMessage' => 'Le numéro de téléphone tapé doit avoir {{ limit }} chiffres',
                        'max' => 10,
                    ]),
            ],
        ])
            
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes d\'utilisation.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('image',FileType::class, [
                'label' => false,
                'mapped' => false,
                'multiple' => true,
                'required' => true  ,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class)
            ->add('roles',ChoiceType::class,array(
                'attr'  =>  array
                (
                    'class' => 'container-fluid',
                    'style' => 'border:none;width:fit-content;background-color:transparent;',
                ),
                'choices'   => array
                (
                
                    'Choix de votre rôle :' => array
                    (
                        'Acheteur' => 'ROLE_ACHETEUR',
                        'Vendeur' => 'ROLE_VENDEUR',
                        'Administrateur' => 'ROLE_ADMIN',
                    )
                ),
                    'required' => true,
                    'expanded' =>true,
                    'multiple'  => true,
                    
                )
            
            )
            //->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('numero_telephone')
            //->add('actif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

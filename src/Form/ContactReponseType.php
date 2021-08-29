<?php

namespace App\Form;

use App\Entity\Contact;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('expediteur')
            //->add('destinataire')
            //->add('sujet')
            //->add('contenu')
            //->add('dateEnvoi')
            ->add('reponse',CKEditorType::class,[
                'label' => 'Réponse',
                'attr' => ['class' => 'text-primary'],
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

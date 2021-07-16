<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Demandes;
use App\Entity\TypeBien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DemandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('superficie',NumberType::class)
            ->add('nbre_pieces',IntegerType::class)
            ->add('nbre_appartements',IntegerType::class)
            ->add('nbre_studios',IntegerType::class)
            ->add('nbre_parking',IntegerType::class)
            ->add('cave',IntegerType::class)
            ->add('budget',NumberType::class)
            ->add('description',TextareaType::class)
            //->add('date_demande')
            //->add('slug')
            ->add('typebien',EntityType::class, [
                'class' => TypeBien::class,
            ])
            //->add('acheteur')
            ->add('adresses',EntityType::class, [
               'class' => Adresse::class,
               'label' =>'Zone de votre recherche',
               'multiple' => true,
              ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demandes::class,
        ]);
    }
}

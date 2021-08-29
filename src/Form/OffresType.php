<?php

namespace App\Form;

use App\Entity\Offres;
use App\Entity\Adresse;
use App\Entity\TypeBien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class, [
                'attr'=>['placeholder'=>'Choisissez le titre de votre annonce'],
            ])
            ->add('superficie',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 500,
                    'step'=> 1,
                ] 
            ])
            ->add('nbre_pieces',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'step'=> 1,
                ] 
            ])
            ->add('nbre_appartements',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'step'=> 1,
                ] 
            ])
            ->add('nbre_studios',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'step'=> 1,
                ] 
            ])
            ->add('places_parking',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'step'=> 1,
                ] 
            ])
            ->add('cave',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'step'=> 1,
                ] 
            ])
            ->add('prix',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 2000000,
                    'step'=> 5000,
                ] 
            ])
            //->add('date_offre')
            ->add('description',TextareaType::class)
            //->add('slug')
            ->add('typebien',EntityType::class, [
                'class' => TypeBien::class,
                'expanded' => true,
            ])
            //->add('vendeur')
            ->add('adresse',EntityType::class, [
                'class' => Adresse::class,
            ])
            ->add('image',FileType::class, [
                'label' => false,
                'mapped' => false,
                'multiple' => true,
                'required' => false,
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}

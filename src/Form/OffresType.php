<?php

namespace App\Form;

use App\Entity\Images;
use App\Entity\Offres;
use App\Entity\Adresse;
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

class OffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('superficie',NumberType::class)
            ->add('nbre_pieces',IntegerType::class)
            ->add('nbre_appartements',IntegerType::class)
            ->add('nbre_studios',IntegerType::class)
            ->add('places_parking',IntegerType::class)
            ->add('cave',IntegerType::class)
            ->add('prix',NumberType::class)
            //->add('date_offre')
            ->add('description',TextareaType::class)
            //->add('slug')
            ->add('typebien',EntityType::class, [
                'class' => TypeBien::class,
            ])
            //->add('vendeur')
            ->add('adresse',EntityType::class, [
                'class' => Adresse::class,
            ])
            // ->add('image',EntityType::class, [
            //     'class' => Images::class,
            // ])
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

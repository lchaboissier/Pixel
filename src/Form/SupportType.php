<?php

namespace App\Form;

use App\Entity\Support;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mainImage', ImageType::class, [
                'label' => 'Image du support',
            ])
            ->add('deleteMainImage', CheckboxType::class, [
                'label' => 'Supprimer l\'image',
                'required' => false
            ])
            ->add('nom')
            ->add('dateSortie', DateType::class, [
                'years' => range(1900,date("Y")),
            ])  
            ->add('description')
            ->add('constructeur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
    }
}

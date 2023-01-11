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
            ->add('nom', options:[
                'label' => 'support.nom'
            ])
            ->add('dateSortie', DateType::class, [
                'label' => 'support.dateSortie',
                // 'years' => range(1900,date("Y")),
                'widget' =>'single_text'
            ])  
            ->add('description', options:[
                'label' => 'support.description',
                'attr' => [
                    'rows' => 12
                ],
            ])
            ->add('constructeur', options:[
                'label' => 'support.constructor',
            ])
            ->add('mainImage', ImageType::class, [
                'label' => 'support.mainImage',
            ])
            ->add('deleteMainImage', CheckboxType::class, [
                'label' => 'Supprimer l\'image',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
    }
}

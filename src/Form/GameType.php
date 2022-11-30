<?php

namespace App\Form;

use App\Entity\Game;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'game.title',
                'help' => 'game.title_help'
            ])
            ->add('editor', null, [
                'label' => 'game.editor',
                'expanded' => true, // Affiche sous forme de radio
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC')
                    ;
                }
            ])
            ->add('description', null, [
                'label' => 'game.description',
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('dateSortie',DateType::class,[
                'label' => 'game.dateSortie',
                'required' => true,
                'widget' => 'choice',
                'years' => range(1972,date("Y")),
            ])
            ->add('enabled', ChoiceType::class, [
                'label' => 'game.enabled',
                'choices' => [
                    'no' => false,
                    'yes' => true,
                ],
                'expanded' => true,
            ])
            ->add('mainImage', ImageType::class, [
                'label' => 'game.main_image',
            ])

            ->add('deleteMainImage', CheckboxType::class, [
                'label' => 'game.delete_main_image',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}

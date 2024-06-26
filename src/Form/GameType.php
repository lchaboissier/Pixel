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
use Symfony\Component\Security\Core\Security;
use App\Form\WysiwygType;

class GameType extends AbstractType
{
    public function __construct(private Security $security) 
    {

    }

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
            ->add('description', WysiwygType::class, [
                'label' => 'game.description',
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('dateSortie',DateType::class,[
                'label' => 'game.dateSortie',
                'required' => true,
                'widget' => 'single_text',
                'years' => range(1972,date("Y")),
            ])
            ->add('support', null,[
                'label' => 'Support de jeu',
            ])
            ->add('mainImage', ImageType::class, [
                'label' => 'Image du jeu',
            ])

            ->add('deleteMainImage', CheckboxType::class, [
                'label' => 'Supprimer l\'image',
                'required' => false
            ])
        ;

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add('enabled', ChoiceType::class, [
                'label' => 'game.enabled',
                'choices' => [
                    'no' => false,
                    'yes' => true,
                ],
                'expanded' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}

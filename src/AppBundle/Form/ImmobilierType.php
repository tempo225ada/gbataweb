<?php

namespace AppBundle\Form;

use AppBundle\Entity\Immobilier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ImmobilierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
                ->add('type', ChoiceType::class, [
                    'choices' => [
                        'Location' => 'location',
                        'Vente' => 'vente'
                    ]
                ])
                ->add('bien', ChoiceType::class, [
                    'choices' => [
                        'Maison' => 'maison',
                        'Terrain' => 'terrain'
                    ]
                ])
                ->add('typebien')
                ->add('commune',EntityType::class, [
                    'class' => 'AppBundle:commune',
                    'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
            ])
                ->add('piece')
                ->add('chambre')
                ->add('douche')
                ->add('prix')
                ->add('description',TextareaType::class, array('attr' => array('class' => 'ckeditor')))
                ->add('utilisateur',HiddenType::class)
                ->add('image', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2048k',
                            'mimeTypes' => ['image/jpeg'
                                ],
                            'mimeTypesMessage' => 'Veuillez uploader des images jpeg ou jpg',
                        ])
                    ],
                ])
                ->add('image2', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2048k',
                            'mimeTypes' => ['image/jpeg'
                                ],
                            'mimeTypesMessage' => 'Veuillez uploader des images jpeg ou jpg',
                        ])
                    ],
                ])
                ->add('image3', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2048k',
                            'mimeTypes' => ['image/jpeg'
                                ],
                            'mimeTypesMessage' => 'Veuillez uploader des images jpeg ou jpg',
                        ])
                    ],
                ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Immobilier::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_immobilier';
    }


}

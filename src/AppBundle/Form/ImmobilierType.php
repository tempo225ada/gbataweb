<?php

namespace AppBundle\Form;

use AppBundle\Entity\Immobilier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImmobilierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
                ->add('type')
                ->add('bien')
                ->add('bienType')
                ->add('commune')
                ->add('prix')
                ->add('piece')
                ->add('chambre')
                ->add('douche')
                ->add('description')
                ->add('image', FileType::class, [
                    'label' => 'Image (jpeg ou jpg)',
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

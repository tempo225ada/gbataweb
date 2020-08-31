<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeImmoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, [
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
                ->add('commune')
                ->add('piece')
                ->add('budget')
                ->add('description')
                ->add('typebien');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DemandeImmo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_demandeimmo';
    }


}

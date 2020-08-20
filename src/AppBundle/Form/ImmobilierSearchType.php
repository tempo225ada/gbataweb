<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\ImmobilierSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ImmobilierSearchType extends AbstractType
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

                ->add('typebien')

                ->add('commune')

                ->add('piece', IntegerType::class, [
                    'required' => false
                ])

                ->add('prix', IntegerType::class, [
                    'required' => false
                ])

            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ImmobilierSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }


}

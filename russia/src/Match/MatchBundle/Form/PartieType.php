<?php

namespace Match\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id',HiddenType::class )
            ->add('datepartie',DateType::class)
            ->add('heurepartie')
            ->add('groupe',HiddenType::class)
            ->add('tour',HiddenType::class)
            ->add('etatmatch',HiddenType::class )
            ->add('etiquette',HiddenType::class )
            ->add('home',HiddenType::class )
            ->add('away',HiddenType::class)
            ->add('idstade',HiddenType::class)
            ->add('save',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Match\MatchBundle\Entity\Partie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'match_matchbundle_partie';
    }


}

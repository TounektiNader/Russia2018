<?php

namespace Match\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomequipe',HiddenType::class)->add('entraineur',HiddenType::class)->add('continent',HiddenType::class)->add('drapeau',HiddenType::class)->add('groupe',HiddenType::class)->add('butmarque',HiddenType::class)->add('butencaisse',HiddenType::class)->add('matchjouee',HiddenType::class)->add('matchnull',HiddenType::class)->add('matchgagne',HiddenType::class)->add('matchperdu',HiddenType::class)
            ->add('nombrepoints',HiddenType::class)
            ->add('filtrer',SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Match\MatchBundle\Entity\Equipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'match_matchbundle_equipe';
    }


}

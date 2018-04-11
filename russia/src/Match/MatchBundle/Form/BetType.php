<?php

namespace Match\MatchBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Valeur')->add('username',HiddenType::class )->add('idpartie',HiddenType::class )
            ->add('captcha',CaptchaType::class,array(
                'width'=>200,
                'height'=>50,
                'length'=>6,
            ))
        ->add('Pariez',SubmitType::class);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Match\MatchBundle\Entity\Bet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'match_matchbundle_bet';
    }


}

<?php

namespace Recompense\RecompensBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class CadeauType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie')
            ->add('type')
            ->add('jeton')
            ->add('image',FileType::class,array('label'=>'Image(PNG)'))
            ->add('tagsText', TextType::class, ['required' => false, 'label' => 'Tags'])
            ->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
            ))
           ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Recompense\RecompensBundle\Entity\Cadeau'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'recompense_recompensbundle_cadeau';
    }


}

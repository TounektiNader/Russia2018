<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 11/03/2018
 * Time: 00:36
 */

namespace Recommandation\RecommandationBundle\Form;


use Russia\RussiaBundle\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class VilleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomville',null,array('attr'=>array('class'=>'form-control')))
            ->add('fondationville',null,array('attr'=>array('class'=>'form-control')))
            ->add('populationville',null,array('attr'=>array('class'=>'form-control')))
            ->add('coordonnees',null,array('attr'=>array('class'=>'form-control')))
            ->add('timezone',null,array('attr'=>array('class'=>'form-control')))
            ->add('equipelocale',null,array('attr'=>array('class'=>'form-control')))
            ->add('photoville', FileType::class, array('data_class' => null,'required' => false,'label' => false))
            ->add('logoville', FileType::class, array('data_class' => null,'required' => false,'label' => false))
            ->add('logoequipe', FileType::class, array('data_class' => null,'required' => false,'label' => false))
            ->add('valider', SubmitType::class);
    }

    public function ConfigureOptions(OptionsResolver $resolver)
    {
    }

    public function getName()
    {
        return 'recommandation_Recommandation_bundle_stade_form';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 11/03/2018
 * Time: 00:36
 */

namespace Recommandation\RecommandationBundle\Form;


use Russia\RussiaBundle\Entity\Cafes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class CafeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomcafe',null,array('attr'=>array('class'=>'form-control')))
            ->add('detailscafe', TextareaType::class, array(
                'attr' => array('cols' => '20', 'rows' => '5','class'=>'form-control'),
            ))
            ->add('positioncafe',null,array('attr'=>array('class'=>'form-control','placeholder'=>'Position','readonly' => true)))
            ->add('photocafe', FileType::class, array('data_class' => null,'required' => true,'label' => false))
            ->add('idville', EntityType::class,array(
                'attr'=> array('class'=>'form-control'),
                'class' => 'Russia\RussiaBundle\Entity\Villes',
                'choice_label' => 'nomville',
                'multiple' => false,
            ))
            ->add('valider', SubmitType::class);
    }

    public function ConfigureOptions(OptionsResolver $resolver)
    {
    }

    public function getName()
    {
        return 'recommandation_Recommandation_bundle_cafe_form';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 11/03/2018
 * Time: 00:36
 */

namespace Recommandation\RecommandationBundle\Form;


use Russia\RussiaBundle\Entity\Hotels;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class HotelForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomhotel',null,array('attr'=>array('class'=>'form-control')))
            ->add('detailshotel', TextareaType::class, array(
                'attr' => array('cols' => '20', 'rows' => '5','class'=>'form-control'),
            ))
            ->add('positionhotel',null,array('attr'=>array('class'=>'form-control')))
            ->add('photohotel', FileType::class, array('data_class' => null,'required' => false,'label' => false))
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
        return 'recommandation_Recommandation_bundle_hotel_form';
    }
}
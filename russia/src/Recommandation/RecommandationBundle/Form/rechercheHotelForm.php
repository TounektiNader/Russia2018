<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 26/03/2018
 * Time: 11:25
 */

namespace Recommandation\RecommandationBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class rechercheHotelForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomhotel',null,array('label'=>false,'attr' => array(
                'placeholder' => 'Recherche',
            )));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'recommandation_Recommandation_bundle_recherche_hotel_form';
    }
}
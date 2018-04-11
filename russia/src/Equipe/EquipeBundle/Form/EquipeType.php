<?php

namespace Equipe\EquipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EquipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomequipe',TextType::class, array('label' => 'Nom de lEquipe'))
            ->add('entraineur',TextType::class, array('label' => 'Entraineur de l equipe'))
            ->add('continent',ChoiceType::class,array('choices'=>array(
                'Afrique'=>'Afrique',
                'Asie'=>'Asie',
                'Amerique du Nord'=>'Amerique du Nord',
                'Amerique du sud'=>'Amerique du sud',
                'Europe'=>'Europe')),
                TextType::class, array('label' => 'Continant de l equipe'))
            ->add('drapeau', 'Symfony\Component\Form\Extension\Core\Type\FileType', array('data_class' => null, 'label'=>false))
            ->add('groupe',ChoiceType::class,array('choices'=>array(
                'A'=>'A',
                'B'=>'B',
                'C'=>'C',
                'D'=>'D',
                'E'=>'E',
                'F'=>'F',
                'G'=>'G',
                'H'=>'H')),TextType::class, array('label' => 'Groupe'))
            ->add('butmarque',TextType::class, array('label' => 'But Marqué'))
            ->add('butencaisse',TextType::class, array('label' => 'But Encaissé'))
            ->add('matchjouee',TextType::class, array('label' => 'Match Joué'))
            ->add('matchnull',TextType::class, array('label' => 'Match Null'))
            ->add('matchgagne',TextType::class, array('label' => 'Match Gagné'))
            ->add('matchperdu',TextType::class, array('label' => 'match Perdu'))
            ->add('nombrepoints',TextType::class, array('label' => 'Nombre de points'))
            ->add('valider',SubmitType::class);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Equipe\EquipeBundle\Entity\Equipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'equipe_equipebundle_equipe';
    }


}

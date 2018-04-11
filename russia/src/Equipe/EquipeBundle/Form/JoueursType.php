<?php

namespace Equipe\EquipeBundle\Form;

use Equipe\EquipeBundle\Entity\Equipe;
use Equipe\EquipeBundle\Entity\Joueurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class JoueursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomjoueur',TextType::class, array('data_class'=>null,'label' => 'Nom joueur'))
            ->add('prenomjoueur',TextType::class, array('data_class'=>null,'label' => 'prenom joueur'))
            ->add('postion',TextType::class, array('data_class'=>null,'label' => 'position du joueur'))
            ->add('idequipe', EntityType::class, array(
               'class' => 'Equipe\EquipeBundle\Entity\Equipe',
                'label' => 'Nom de lequipe',
                'choice_label' => 'nomequipe',
                'multiple' => false,
                'data_class'=>null

            ))
            ->add('valider', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Equipe\EquipeBundle\Entity\Joueurs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'equipe_equipebundle_joueurs';
    }


}

<?php
/**
 * Created by PhpStorm.
 * User: gaelfameni
 * Date: 08/04/2018
 * Time: 10:59
 */

namespace Russia\RussiaBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('textcom')->add('Ajouter Commentaire',SubmitType::class);
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Russia\RussiaBundle\Entity\Commentaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'russia_russiabundle_commentaire';
    }



}
<?php
namespace Discutea\DForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'discutea.forum.forum.form.name'))
            ->add('description', TextType::class, array('label' => 'discutea.forum.forum.form.description'))
            ->add('image', FileType::class, array(
                'data_class' => null
            ))
            ->add('category', EntityType::class, array(
                'label'        => 'discutea.forum.forum.form.category',
                'class'        => 'DForumBundle:Category',
                'choice_label' => 'name',
            ))
            ->add('position',HiddenType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Discutea\DForumBundle\Entity\Forum',
            'roles' => null
        ));
    }
}

<?php

namespace Frontend\CommentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('txt', 'textarea', array('label' => 'Текст комментария'));
    }

    public function getName()
    {
        return 'comment';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array(
            'data_class' => 'Frontend\CommentBundle\Entity\Comment',
        );
    }
}
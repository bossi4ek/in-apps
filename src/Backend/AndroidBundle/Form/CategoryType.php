<?php

namespace Backend\AndroidBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('is_publish', 'checkbox', array(
                    'required'  => false));
    }

    public function getName()
    {
        return 'category';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array(
            'data_class' => 'Frontend\AndroidBundle\Entity\Category',
        );
    }
}
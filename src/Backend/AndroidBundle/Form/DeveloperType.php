<?php

namespace Backend\AndroidBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('is_publish', 'checkbox', array(
                    'required'  => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array(
            'data_class' => 'Frontend\AndroidBundle\Entity\Developer',
        );
    }

    public function getName()
    {
        return 'developer';
    }
}
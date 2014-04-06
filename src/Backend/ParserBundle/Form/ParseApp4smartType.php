<?php

namespace Backend\ParserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ParseApp4smartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url', 'text')
                ->add('with_category', 'checkbox', array(
                    'required'  => false));
    }

    public function getName()
    {
        return 'app4smart';
    }
}
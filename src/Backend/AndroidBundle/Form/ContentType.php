<?php

namespace Backend\AndroidBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('tags', 'collection', array(
                    'type' => new TagType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ))
                ->add('description', 'textarea')
                ->add('file', 'file')
                ->add('category', 'entity', array(
                      'multiple' => true,
                      'class' => 'FrontendAndroidBundle:Category',
                      'query_builder' => function(EntityRepository $er) {
                          return $er->createQueryBuilder('category')
                                    ->where('category.is_publish = :is_publish')
                                    ->setParameter('is_publish', '1')
                                    ->orderBy('category.name', 'ASC');
                      },
                      'property' => 'name'
                ))
                ->add('developer', 'entity', array(
                      'multiple' => true,
                      'class' => 'FrontendAndroidBundle:Developer',
                      'query_builder' => function(EntityRepository $er) {
                          return $er->createQueryBuilder('developer')
                                    ->where('developer.is_publish = :is_publish')
                                    ->setParameter('is_publish', '1')
                                    ->orderBy('developer.name', 'ASC');
                      },
                      'property' => 'name'
                ))
                ->add('is_publish', 'checkbox', array(
                    'required'  => false,
                ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array(
            'data_class' => 'Frontend\AndroidBundle\Entity\Content',
//            'validation_groups' => array("xz")
        );
    }

    public function getName()
    {
        return 'content';
    }
}
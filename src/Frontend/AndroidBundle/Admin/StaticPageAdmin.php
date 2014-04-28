<?php

namespace Frontend\AndroidBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StaticPageAdmin extends Admin {
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Название'))
            ->add('description', 'textarea', array(
                'label' => 'Описание',
                'required' => false,
            ))
            ->add('meta_title', 'text', array('label' => 'Meta title'))
            ->add('meta_keywords', 'text', array('label' => 'Meta keywords'))
            ->add('meta_description', 'textarea', array(
                'label' => 'Meta description',
                'required' => true,
            ))
            ->add('is_publish', 'checkbox', array(
                'label' => 'Опубликовать',
                'required'  => false,
            ));
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('is_publish')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description')
            ->add('slug')
            ->add('is_publish')
        ;
    }
} 
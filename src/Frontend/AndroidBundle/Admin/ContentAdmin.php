<?php

namespace Frontend\AndroidBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Doctrine\ORM\EntityRepository;

class ContentAdmin extends Admin {
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $image = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        $fileFieldOptions['label'] = 'Главный постер';
        if ($image && ($webPath = $image->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="poster_img" />';
        }

        $formMapper
            ->add('name', 'text', array('label' => 'Название'))
            ->add('description', 'textarea', array(
                'label' => 'Описание',
                'required' => true,
            ))
            ->add('meta_title', 'text', array('label' => 'Meta title'))
            ->add('meta_keywords', 'text', array('label' => 'Meta keywords'))
            ->add('meta_description', 'textarea', array(
                'label' => 'Meta description',
                'required' => true,
            ))
            ->add('file', 'file', $fileFieldOptions)
            ->add('categories', 'entity', array(
                'multiple' => true,
                'class' => 'FrontendAndroidBundle:Category',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('category')
                            ->where('category.is_publish = :is_publish')
                            ->setParameter('is_publish', '1')
                            ->orderBy('category.name', 'ASC');
                    },
                'property' => 'name',
                'label' => 'Категории'
            ))
            ->add('developers', 'entity', array(
                'multiple' => true,
                'class' => 'FrontendAndroidBundle:Developer',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('developer')
                            ->where('developer.is_publish = :is_publish')
                            ->setParameter('is_publish', '1')
                            ->orderBy('developer.name', 'ASC');
                    },
                'property' => 'name',
                'label'    => 'Разработчики'
            ))
            ->add('year', 'text', array('label' => 'Год'))
            ->add('size', 'text', array('label' => 'Размер'))
            ->add('version', 'text', array('label' => 'Версия'))
            ->add('install_count', 'text', array('label' => 'Количество установок'))
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
            ->add('slug')
            ->add('created')
            ->add('updated')
            ->add('is_publish')
        ;
    }
} 
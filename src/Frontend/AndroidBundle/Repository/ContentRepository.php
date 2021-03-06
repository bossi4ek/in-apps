<?php

namespace Frontend\AndroidBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{
    private $is_api = false;

    public function setIsApi($is_api)
    {
        $this->is_api = $is_api;
    }

    public function getIsApi()
    {
        return $this->is_api;
    }

//======================================================================================================================
    public function findAllContent()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                ORDER BY content.created DESC');

        if (!$this->getIsApi()) return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findAllContentForSitemap()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                ORDER BY content.created DESC');
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findOneBySlug($slug)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                WHERE content.slug = :slug'
            )->setParameter('slug', $slug);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findContentByName($name)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                WHERE content.name LIKE :name'
            )->setParameter('name', '%'.$name.'%');

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findTopContent()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                ORDER BY content.view_count DESC')->setMaxResults(10);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findTopContentByCategory($slug)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                LEFT JOIN content.categories category
                WHERE category.slug = :slug
                ORDER BY content.view_count DESC'
            )->setParameter('slug', $slug)->setMaxResults(6);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findNewContent()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                ORDER BY content.created DESC')->setMaxResults(10);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findAllByCategory($slug)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                LEFT JOIN content.categories category
                WHERE category.slug = :slug
                ORDER BY content.created DESC'
            )->setParameter('slug', $slug);

        if (!$this->getIsApi()) return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findAllByDeveloper($slug)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                LEFT JOIN content.developers developer
                WHERE developer.slug = :slug
                ORDER BY content.created DESC'
            )->setParameter('slug', $slug);

        if (!$this->getIsApi()) return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function findAllContentByIsPublish()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                WHERE content.is_publish = :is_publish
                ORDER BY content.created DESC')
            ->setParameter('is_publish', 1);

        if (!$this->getIsApi()) return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
    public function checkExistContentInUser($id_content, $id_user)
    {
        $content = $this->getEntityManager()
            ->getRepository('FrontendUserBundle:User')
            ->findOneById($id_user);

        $data = $content->getContents();

        foreach ($data as $key => $value) {
            if ($value->getId() == $id_content) {
                return 1;
            }
        }

        return 0;
    }

//======================================================================================================================
    public function findOneContentById($id_content)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                WHERE content.id = :id'
            )->setParameter('id', $id_content);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

}

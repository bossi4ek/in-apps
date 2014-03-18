<?php

namespace Frontend\AndroidBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{

    public function findAllContent()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                ORDER BY content.created DESC');

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

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

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

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

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findAllContentByIsPublish()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                WHERE content.is_publish = :is_publish
                ORDER BY content.created DESC')
            ->setParameter('is_publish', 1);

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

//======================================================================================================================
//For API
    public function findApiAllContent()
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

    public function findApiContentById($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                WHERE content.id = :id'
            )->setParameter('id', $id);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}

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

    public function findTopContentByCategory($slug)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                LEFT JOIN content.categories category
                WHERE category.slug = :slug
                ORDER BY content.view_count DESC'
            )->setParameter('slug', $slug)->setMaxResults(5);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

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

    public function checkExistContentInUser($slug, $id_user)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM FrontendAndroidBundle:Content content
                LEFT JOIN content.users user
                WHERE user.id = :id_user AND content.slug = :slug
                ORDER BY content.created DESC'
            )->setParameter('id_user', $id_user)->setParameter("slug", $slug);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

}

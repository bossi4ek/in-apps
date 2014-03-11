<?php

namespace Frontend\AndroidBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{

    public function findAllFilms()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                ORDER BY content.created DESC');

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findAllFilmsByIsPublish()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
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

    public function findAllFilmsForSitemap()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
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
                FROM Sf2filmsFilmsBundle:Content content
                WHERE content.slug = :slug'
            )->setParameter('slug', $slug);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findAllByGenre($translit)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                LEFT JOIN content.genres genre
                WHERE genre.name_translit = :translit
                ORDER BY content.created DESC'
            )->setParameter('translit', $translit);

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findAllByPerson($translit)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                LEFT JOIN content.persons person
                WHERE person.name_translit = :translit
                ORDER BY content.created DESC'
            )->setParameter('translit', $translit);

        return $query;

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}

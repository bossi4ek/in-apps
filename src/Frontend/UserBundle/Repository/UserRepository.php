<?php

namespace Frontend\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function findAllUserContent($id_user)
    {
//        $query = $this->getEntityManager()
//            ->createQuery('
//                SELECT content
//                FROM Sf2filmsFilmsBundle:Content content
//                LEFT JOIN content.persons person
//                WHERE person.name_translit = :translit
//                ORDER BY content.created DESC'
//            )->setParameter('translit', $translit);
//
//        return $query;
//
//        try {
//            return $query->getResult();
//        } catch (\Doctrine\ORM\NoResultException $e) {
//            return null;
//        }
    }
}

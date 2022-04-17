<?php

    namespace App\Repository;

    use App\Entity\Pointage;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\ORM\OptimisticLockException;
    use Doctrine\ORM\ORMException;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * @method Pointage|null find($id, $lockMode = null, $lockVersion = null)
     * @method Pointage|null findOneBy(array $criteria, array $orderBy = null)
     * @method Pointage[]    findAll()
     * @method Pointage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
    class PointageRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Pointage::class);
        }

        /**
         * @throws ORMException
         * @throws OptimisticLockException
         */
        public function add(Pointage $entity, bool $flush = true): void
        {
            $this->_em->persist($entity);
            if ($flush) {
                $this->_em->flush();
            }
        }

        /**
         * @throws ORMException
         * @throws OptimisticLockException
         */
        public function remove(Pointage $entity, bool $flush = true): void
        {
            $this->_em->remove($entity);
            if ($flush) {
                $this->_em->flush();
            }
        }


        public function CountPointageChantier(Pointage $pointage, $state)
        {

            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                'SELECT p
            FROM App\Entity\Pointage p
            WHERE p.utilisateur =:utilisateur
            and p.chantier=:chantier
            and p.date=:date
            ORDER BY p.id DESC '
            )->setParameter('utilisateur', $pointage->getUtilisateur())
                ->setParameter('chantier', $pointage->getChantier())
                ->setParameter('date', $pointage->getDate());
            if ($state == 'new')
                return count($query->getResult()) + 1;
            else {
                $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($pointage);
                if ($originalData['utilisateur_id'] == $pointage->getUtilisateur()->getId())
                    return count($query->getResult());
                else
                    return count($query->getResult())+1;
            }
        }


        public function SommeDureePointageUser(Pointage $pointage, $state)
        {

            $date = $pointage->getDate()->format('Y-m-d');

            $week = date("W", strtotime($date));
            $year = date("o", strtotime($date));
            $week = sprintf("%02s", $week);

            $startDate = date('Y-m-d', strtotime("$year-W$week-1"));
            $endDate = date('Y-m-d', strtotime($startDate . ' + 6 days'));


            $days = $this->createQueryBuilder('p')
                ->select('SUM(p.duree) as somme')
                ->andWhere('p.date >= :start and p.date <= :end')
                ->andWhere('p.utilisateur =:utilisateur')
                ->setParameter('start', $startDate)
                ->setParameter('end', $endDate)
                ->setParameter('utilisateur', $pointage->getUtilisateur())
                ->getQuery()
                ->getOneOrNullResult();
            $somme = 0;
            if ($days['somme'])
                $somme = $days['somme'];

            if ($state == 'new') $somme += $pointage->getDuree();
            else {
                $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($pointage);
                if ($originalData['utilisateur_id'] == $pointage->getUtilisateur()->getId())
                    $somme = $somme - $originalData['duree'] + $pointage->getDuree();
                else
                    $somme = $somme + $pointage->getDuree();
            }
            return $somme;

        }

    }

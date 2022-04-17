<?php

    namespace App\Repository;

    use App\Entity\Chantier;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\ORM\OptimisticLockException;
    use Doctrine\ORM\ORMException;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * @method Chantier|null find($id, $lockMode = null, $lockVersion = null)
     * @method Chantier|null findOneBy(array $criteria, array $orderBy = null)
     * @method Chantier[]    findAll()
     * @method Chantier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
    class ChantierRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Chantier::class);
        }

        /**
         * @throws ORMException
         * @throws OptimisticLockException
         */
        public function add(Chantier $entity, bool $flush = true): void
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
        public function remove(Chantier $entity, bool $flush = true): void
        {
            $this->_em->remove($entity);
            if ($flush) {
                $this->_em->flush();
            }
        }
    }

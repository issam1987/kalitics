<?php


    namespace App\Service;


    use App\Entity\Pointage;
    use Doctrine\ORM\EntityManagerInterface;

    class PointageHelper
    {
        private $em;
        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        public function parse(Pointage $pointage, $state): string
        {
            $error='';

            $maxPointage=$this->em->getRepository(Pointage::class)->CountPointageChantier($pointage, $state);
            if($maxPointage>1)
                $error.=" Vous ne pouvez pas pointé deux fois le même jour sur le même chantier .";
            $sommeDuree= $this->em->getRepository(Pointage::class)->SommeDureePointageUser($pointage, $state);
            if($sommeDuree>35)
                $error.=' La somme des durées des pointages d’un utilisateur pour une semaine ne pourra pas dépasser 35 heures .';

            return $error;


        }
    }

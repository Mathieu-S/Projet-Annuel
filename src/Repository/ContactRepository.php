<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function getReceiverContactRequests($idReceiver)
    {
        return $this->createQueryBuilder('c')
            ->join('c.receiver', 'receiver')
            ->where('receiver.id = :value')->setParameter('value', $idReceiver)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getUserContactRequests($idUser)
    {
        return $this->createQueryBuilder('c')
            ->join('c.receiver', 'receiver')
            ->join('c.sender', 'sender')
            ->where('receiver.id = :value')->setParameter('value', $idUser)
            ->orWhere('sender.id = :value')
            ->getQuery()
            ->getResult()
            ;
    }

}

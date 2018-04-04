<?php

namespace App\Persistence;

use Doctrine\ORM\Persisters\PersisterException;

abstract class BaseDAO
{
    /** @var  \Doctrine\ORM\EntityManager */
    protected $em;

    public function save($object)
    {
        try {
            $this->em->persist($object);
            $this->em->flush();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function delete($object)
    {
        try {
            $this->em->remove($object);
            $this->em->flush();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function persist($object)
    {
        $this->em->persist($object);
    }

    public function flush()
    {
        try {
            $this->em->flush();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function clear()
    {
        $this->em->clear();
    }
}

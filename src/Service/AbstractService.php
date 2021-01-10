<?php


namespace App\Service;


use App\Entity\Progress;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Workspace;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This abstract class was created to handle the basic crud operations from the entityManager
 * @package App\Service
 */
class AbstractService
{

    private $entityManager;

    /**
     * AbstractService constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This method saves an entity object to the db
     * @param $anEntityObject
     */
    public function save($anEntityObject) {

        $this->checkIfObjectIsEntityObject($anEntityObject);
        $this->entityManager->persist($anEntityObject);
        $this->entityManager->flush();
    }

    /**
     * This method updates an entity object to the db
     * @param $anEntityObject
     */
    public function update($anEntityObject) {

        // Doctrine recognizes that the entity that needs to be updated, exists in db
        // so there is no need to call merge, the same operation will be done by persist
        // that's why I am calling save
        $this->save($anEntityObject);
    }

    /**
     * This methods deletes an entity object from the db
     * @param $anEntityObject
     */
    public function delete($anEntityObject) {
        $this->checkIfObjectIsEntityObject($anEntityObject);
        $this->entityManager->remove($anEntityObject);
        $this->entityManager->flush();
    }

    private function checkIfObjectIsEntityObject($anObject) {

        if (!$anObject instanceof Progress && !$anObject instanceof Task && !$anObject instanceof User && !$anObject instanceof Workspace) {
            throw new \LogicException('The object provided to save to the database, is not a valid Entity object.');

        }
    }
}
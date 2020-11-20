<?php

namespace App\DataFixtures;

use App\Entity\Workspace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WorkspaceFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(1, 'workpaces', function ($i) {

            $workspace = new Workspace();

            $workspace->setName("My workspace");
            $workspace->setDescription("This is an auto generated workpce to get you started!");

            $workspace->addUserId($this->getReference('users_0'));

            $workspace->addTaskId(null);

            $workspace->addProgressId($this->getReference('progresses_0'));
            $workspace->addProgressId($this->getReference('progresses_1'));
            $workspace->addProgressId($this->getReference('progresses_2'));
            $workspace->addProgressId($this->getReference('progresses_3'));

            return $workspace;
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ProgressFixtures::class
        ];
    }
}

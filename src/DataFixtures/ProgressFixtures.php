<?php

namespace App\DataFixtures;

use App\Entity\Progress;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class ProgressFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(4, 'progresses', function ($i) {

            $progress = new Progress();

            switch ($i) {
                case 0:
                    $progress->setDescription("To Research");
                    $progress->setColor("#B731FF");
                    $progress->setPriority(4);
                    $progress->addUser($this->getReference('users_0'));
                    break;
                case 1:
                    $progress->setDescription("To Do");
                    $progress->setColor("#5B8DF4");
                    $progress->setPriority(3);
                    $progress->addUser($this->getReference('users_0'));
                    break;
                case 2:
                    $progress->setDescription("Doing");
                    $progress->setColor("#FF9524");
                    $progress->setPriority(2);
                    $progress->addUser($this->getReference('users_0'));
                    break;
                case 3:
                    $progress->setDescription("Done");
                    $progress->setColor("#FFCC00");
                    $progress->setPriority(1);
                    $progress->addUser($this->getReference('users_0'));
                    break;
            }

            $progress->setWorkspace(null);

            return $progress;

        });
        $manager ->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}

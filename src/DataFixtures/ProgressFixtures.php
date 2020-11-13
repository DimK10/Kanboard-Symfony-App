<?php

namespace App\DataFixtures;

use App\Entity\Progress;
use Doctrine\Persistence\ObjectManager;


class ProgressFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(4, 'progresses', function ($i) {

            $progress = new Progress();

            switch ($i) {
                case 0:
                    $progress->setDescription("To Research");
                    break;
                case 1:
                    $progress->setDescription("To Do");
                    break;
                case 2:
                    $progress->setDescription("Doing");
                    break;
                case 3:
                    $progress->setDescription("Done");
                    break;
            }

            $progress->setWorkspaceId(null);

            return $progress;

        });
        $manager ->flush();
    }
}

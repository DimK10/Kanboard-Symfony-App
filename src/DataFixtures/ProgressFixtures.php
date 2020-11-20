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
                    $progress->setColor("#B731FF");
                    $progress->setPriority(4);
                    break;
                case 1:
                    $progress->setDescription("To Do");
                    $progress->setColor("#5B8DF4");
                    $progress->setPriority(3);
                    break;
                case 2:
                    $progress->setDescription("Doing");
                    $progress->setColor("#FF9524");
                    $progress->setPriority(2);
                    break;
                case 3:
                    $progress->setDescription("Done");
                    $progress->setColor("#FFCC00");
                    $progress->setPriority(1);
                    break;
            }

            $progress->setWorkspaceId(null);

            return $progress;

        });
        $manager ->flush();
    }
}

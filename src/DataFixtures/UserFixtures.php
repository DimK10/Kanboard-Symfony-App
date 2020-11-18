<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Workspace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(3, 'users', function ($i) {
            $user = new User();

            $user->setEmail(sprintf('user%d@gmail.com', $i));
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);

            $user->setRoles(["IS_AUTHENTICATED_FULLY"]);
            $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));

            $user->addWorkspaceId(null);


            return $user;
        });

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i) {
            $user = new User;

            return $user->setEmail(sprintf('spacebar%d@example.com', $i))
                ->setPassword($this->passwordEncoder->encodePassword($user, 'engage'))
                ->setFirstName($this->faker->firstName);
        });

        $this->createMany(3, 'admin_users', function($i) {
            $user = new User;

            return $user->setEmail(sprintf('admin%d@thespacebar.com', $i))
                ->setPassword($this->passwordEncoder->encodePassword($user, 'engage'))
                ->setFirstName($this->faker->firstName)
                ->setRoles(['ROLE_ADMIN']);
        });

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$name, $last_name, $email, $password, $api_key, $roles])
        {
            $user = new User();
            $user->setName($name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setVimeoApiKey($api_key);
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [

            ['John', 'Wayne', 'admin@symf4.loc', 'passw', '9465703f9e330ef0767472884a2b18a7', ['ROLE_ADMIN']],
            ['John', 'Doe1', 'u1@symf4.loc', 'passw', null, ['ROLE_ADMIN']],
            ['John', 'Doe2', 'u2@symf4.loc', 'passw', null, ['ROLE_USER']],
            ['John', 'Doe3', 'u3@symf4.loc', 'passw', null, ['ROLE_USER']],
            ['John', 'Doe4', 'u4@symf4.loc', 'passw', null, ['ROLE_USER']],

        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AdminFixtures extends Fixture
{

    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory,
        private string $adminPassword,
    ) {
    }

    public static function getEnvironmentVariables(): array {
        return [ 'ADMIN_PASSWORD' ];
    }

    public function load( ObjectManager $manager ): void {
        $admin = new User();
        $admin->setEmail( 'admin@gmail.com' );
        $admin->setRoles( [ 'ROLE_ADMIN' ] );
        $admin->setPassword( $this->passwordHasherFactory->getPasswordHasher( User::class )->hash( $this->adminPassword ) );
        $admin->setLastname( 'admin' );
        $admin->setFirstname( 'admin' );
        $admin->setAdress( '8 Av. du Dr Poulain' );
        $admin->setZipcode( '61140' );
        $admin->setCity( 'Bagnoles de l\'orne');
        
        $manager->persist($admin);

        $manager->flush();
    }
}


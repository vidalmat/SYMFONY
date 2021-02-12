<?php

namespace App\DataFixtures;

use DateTime;
use DateTimeZone;
use App\Entity\User;
use App\Entity\Subject;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setPseudo("Toto")
            ->setEmail("test@gmail.com")
            ->setAdress("35 rue des Lilas 84000 Avignon")
            ->setName("Dupond")
            ->setPassword($this->encoder->encodePassword($user, "test"))
            ->setRole(["ROLE_ADMIN"]);

        $manager->persist($user);

        for($i = 0; $i < 3; $i++) {

            $sujet = new Subject();
        $sujet->setDescription("Sujet n°".$i)
            ->setUser($user)
            ->setCreatedAt(new DateTime("now", new DateTimeZone("europe/paris")));

            $manager->persist($sujet);

            for($j = 0; $j < 5; $j++){

                $post = new Post();
                $post->setSubject($sujet)
                    ->setUser($user)
                    ->setContent("Je suis le post n°".$j."du sujet n°".$j)
                    ->setPostedAt(new DateTime("now", new DateTimeZone("europe/paris")));

                $manager->persist($sujet);
            }


        }

        $manager->flush();
    }
}

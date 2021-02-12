<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Subject;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    /**
     * Je récupère via l'injection de services mon objet encoder, utile pour encoder le mot de passe
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    /**
     * Lancement du chargement des fixtures avec la commande :
     * php bin/console doctrine:fixtures:load
     * @param ObjectManager $manager
     * 
     * @return [type]
     */
    public function load(ObjectManager $manager)
    {
        //$product = new Product();
        //$manager->persist($product);

        $user = new User();
        $user->setPseudo('Test')
            ->setEmail('test2@gmail.com')
            ->setAddress('35 rue des Lilas 84000 Avignon')
            ->setName('Dupond')
            ->setPassword($this->encoder->encodePassword($user, 'test'))
            ->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($user);

        for($i = 0; $i < 3; $i++) {

            $sujet = new Subject();
            $sujet->setDescription("Sujet n° ".$i)
                ->setUser($user)
                ->setCreatedAt(new DateTime('now', new DateTimeZone('europe/paris')));

            $manager->persist($sujet);

            for($j = 0; $j < 5; $j++) {

                $post = new Post();
                $post->setSubject($sujet)
                    ->setUser($user)
                    ->setContent("Je suis le post n° ".$j." du sujet n° ".$i)
                    ->setPostedAt(new DateTime('now', new DateTimeZone('europe/paris')));

                $manager->persist($post);
            }
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\Langue;
use App\Entity\Livre;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des Editeurs
        $editeurs = [];
        for ($i = 0; $i < 5; $i++) {
            $editeur = new Editeur();
            $editeur->setNom($faker->company);
            $manager->persist($editeur);
            $editeurs[] = $editeur;
        }

        // Création des Editeurs
        $langues = [];
        for ($i = 0; $i < 5; $i++) {
            $langue = new Langue();
            $langue->setNom($faker->languageCode);
            $manager->persist($langue);
            $langues[] = $langue;
        }

        // Création des Genres
        $genres = [];
        for ($i = 0; $i < 5; $i++) {
            $genre = new Genre();
            $genre->setNom($faker->word);
            $genre->setDescription($faker->text);
            $manager->persist($genre);
            $genres[] = $genre;
        }

        // Création des Utilisateurs
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(password_hash('password', PASSWORD_BCRYPT)); // Fake password
            $manager->persist($user);
            $users[] = $user;
        }

        $auteurs = [];
        for ($i = 0; $i < 10; $i++) {
            $auteur = new Auteur();
            $auteur->setNationalite($faker->country);
            $auteur->setBiographie($faker->text(200));
            $auteur->setDateNaissance(new DateTime());
            $auteur->setPhoto('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFlqa7Kso7R6Tvu9hPCHUqgTSOWhu6C_pdnw&s');
            $auteur->setNom($faker->lastName);
            $auteur->setPrenom($faker->firstName);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }

        for ($i = 0; $i < 50 ; $i++){
            $livre = new Livre;
            $livre->setTitre('Livre n°'. $i);
            $livre->setDescription($faker->text);
            $livre->setDateParution(new DateTime());
            $livre->setNombrePages(random_int(100,500));
            $livre->setUser($users[array_rand($users)]);
            $livre->setEditeur($editeurs[array_rand($editeurs)]);
            $livre->setGenreId($genres[array_rand($genres)]);
            $livre->addAuteur($auteurs[array_rand($auteurs)]);
            $livre->setLangue($langues[array_rand($langues)]);
            $livre->setImage('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFlqa7Kso7R6Tvu9hPCHUqgTSOWhu6C_pdnw&s');
            $manager->persist($livre);
        }

        $manager->flush();
    }
}

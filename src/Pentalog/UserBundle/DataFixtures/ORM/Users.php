<?php

//namespace Pentalog\UserBundle\DataFixtures\ORM;
//
//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;
//use Pentalog\UserBundle\Entity\User;
//
//class Users implements FixtureInterface {
//
//    public function load(ObjectManager $manager) {
//        // Les noms d'utilisateurs à créer
//        $names = array('winzou', 'John', 'Talus');
//
//        foreach ($names as $i => $name) {
//            // On crée l'utilisateur
//            $users[$i] = new User;
//
//            // Le nom d'utilisateur et le mot de passe sont identiques
//            $users[$i]->setUsername($name);
//            $users[$i]->setPassword($name);
//
//            // Le sel et les rôles sont vides pour l'instant
//            $users[$i]->setSalt('');
//            $users[$i]->setRoles(array());
//
//            // On le persiste
//            $manager->persist($users[$i]);
//        }
//
//        // On déclenche l'enregistrement
//        $manager->flush();
//    }
//
//}

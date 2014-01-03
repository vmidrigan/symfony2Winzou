<?php

namespace Pentalog\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pentalog\BlogBundle\Entity\Category;

class Categories extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager) {
        // Liste des noms de catégorie à ajouter
        $names = array('Symfony2', 'Doctrine2', 'Tutoriel', 'Évènement');

        foreach ($names as $i => $name) {
            // On crée la catégorie
            $categoryList[$i] = new Category();
            $categoryList[$i]->setName($name);

            // On la persiste
            $manager->persist($categoryList[$i]);
            $this->addReference("category$i", $categoryList[$i]);
        }

        // On déclenche l'enregistrement
        $manager->flush();       
    }
    
    public function getOrder() {
        return 1;
    }
}

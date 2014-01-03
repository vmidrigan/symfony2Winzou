<?php

namespace Pentalog\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pentalog\BlogBundle\Entity\Competence;

class Competences extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager) {
        $names = array('Doctrine', 'Formulaire', 'Twig');
        
        foreach ($names as $i => $name) {
            $compList[$i] = new Competence();
            $compList[$i]->setName($name);
            $manager->persist($compList[$i]);
            $this->addReference("competence$i", $compList[$i]);
        }
        
        $manager->flush();
    }
    
    public function getOrder() {
        return 3;
    }
}
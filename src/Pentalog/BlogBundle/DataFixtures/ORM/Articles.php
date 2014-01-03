<?php

namespace Pentalog\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pentalog\BlogBundle\Entity\Article;

class Articles extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        $article1 = new Article();
        $article1->setAuthor('Victoria');
        $article1->setContent('It was a wonderful summer with a lot of events...');
        $article1->setTitle('How I spent my summer');
        $article1->addCategory($manager->merge($this->getReference('category3')));
        
        $article2 = new Article();
        $article2->setAuthor('Mihai');
        $article2->setContent('I like Symfony 2 because it\'s pretty easy and I like its structure and principles');
        $article2->setTitle('Why I like Symfony2');
        $article2->addCategory($manager->merge($this->getReference('category0')));
        $article2->addCategory($manager->merge($this->getReference('category1')));
        $article2->addCategory($manager->merge($this->getReference('category2')));
        
        $article3 = new Article();
        $article3->setAuthor('Igor');
        $article3->setContent('Symfony 2.4 has a few difference from the previous versions. You should take a quick look at the list below');
        $article3->setTitle('Symfony 2.4');
        $article3->addCategory($manager->merge($this->getReference('category0')));
        $article3->addCategory($manager->merge($this->getReference('category1')));
        
        $manager->persist($article1);
        $manager->persist($article2);
        $manager->persist($article3);
        
        $this->addReference('article1', $article1);
        $this->addReference('article2', $article2);
        $this->addReference('article3', $article3);
        

        // On déclenche l'enregistrement
        $manager->flush();
    }
    
    public function getOrder() {
        return 2;
    }
}

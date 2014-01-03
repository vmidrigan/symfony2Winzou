<?php

namespace Pentalog\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pentalog\BlogBundle\Entity\ArticleCompetence;

class ArticleCompetences extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager) {
        $ac1 = new ArticleCompetence();
        $ac1->setArticle($manager->merge($this->getReference('article2')));
        $ac1->setCompetence($manager->merge($this->getReference('competence0')));
        $ac1->setLevel('Begginer');
        
        $ac3 = new ArticleCompetence();
        $ac3->setArticle($manager->merge($this->getReference('article2')));
        $ac3->setCompetence($manager->merge($this->getReference('competence1')));
        $ac3->setLevel('Begginer');
        
        $ac4 = new ArticleCompetence();
        $ac4->setArticle($manager->merge($this->getReference('article2')));
        $ac4->setCompetence($manager->merge($this->getReference('competence2')));
        $ac4->setLevel('Begginer');
        
        $ac2 = new ArticleCompetence();
        $ac2->setArticle($manager->merge($this->getReference('article3')));
        $ac2->setCompetence($manager->merge($this->getReference('competence0')));
        $ac2->setLevel('Expert');
        
        $ac5 = new ArticleCompetence();
        $ac5->setArticle($manager->merge($this->getReference('article3')));
        $ac5->setCompetence($manager->merge($this->getReference('competence1')));
        $ac5->setLevel('Intermidiate');
        
        $ac6 = new ArticleCompetence();
        $ac6->setArticle($manager->merge($this->getReference('article3')));
        $ac6->setCompetence($manager->merge($this->getReference('competence2')));
        $ac6->setLevel('Intermidiate');
        
        $manager->persist($ac1);
        $manager->persist($ac2);
        $manager->persist($ac3);
        $manager->persist($ac4);
        $manager->persist($ac5);
        $manager->persist($ac6);
        
        $manager->flush();
    }
    
    public function getOrder() {
        return 4;
    }
}


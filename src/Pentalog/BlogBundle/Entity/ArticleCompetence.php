<?php

namespace Pentalog\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCompetence
 *
 * @ORM\Table(name="article_competence")
 * @ORM\Entity
 */
class ArticleCompetence
{
    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pentalog\BlogBundle\Entity\Article")
     */
    private $article;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pentalog\BlogBundle\Entity\Competence")
     */
    private $competence;

    /**
     * Set level
     *
     * @param string $level
     * @return ArticleCompetence
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set article
     *
     * @param \Pentalog\BlogBundle\Entity\Article $article
     * @return ArticleCompetence
     */
    public function setArticle(\Pentalog\BlogBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Pentalog\BlogBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set competence
     *
     * @param \Pentalog\BlogBundle\Entity\Competence $competence
     * @return ArticleCompetence
     */
    public function setCompetence(\Pentalog\BlogBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \Pentalog\BlogBundle\Entity\Competence 
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}

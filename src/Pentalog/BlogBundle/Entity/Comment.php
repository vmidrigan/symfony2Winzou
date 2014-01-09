<?php

namespace Pentalog\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pentalog\BlogBundle\Validator\AntiFlood;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Pentalog\BlogBundle\Entity\CommentRepository")
 */
class Comment {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @AntiFlood()
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pentalog\BlogBundle\Entity\Article", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    public function __construct() {
        $this->date = new \Datetime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }


    /**
     * Set article
     *
     * @param \Pentalog\BlogBundle\Entity\Article $article
     * @return Comment
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
}

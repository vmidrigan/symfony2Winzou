<?php

namespace Pentalog\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Pentalog\BlogBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

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
     */
    private $content;

    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="publication", type="boolean") 
     */
    private $publication;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="update_date", type="datetime")
     */
    private $update_date;

    /**
     * @ORM\OneToOne(targetEntity="Pentalog\BlogBundle\Entity\Image", cascade={"persist"})
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Pentalog\BlogBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;
    
    /**
     * @ORM\OneToMany(targetEntity="Pentalog\BlogBundle\Entity\Comment", mappedBy="article")
     */
    private $comments; // Ici commentaires prend un « s », car un article a plusieurs commentaires !
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __construct() {
        $this->date = new \Datetime(); // Par défaut, la date de l'article est la date d'aujourd'hui
        $this->publication = true;
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Article
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
     * @return Article
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
     * Set publication
     *
     * @param boolean $publication
     * @return Article
     */
    public function setPublication($publication) {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication() {
        return $this->publication;
    }

    /**
     * Set image
     *
     * @param \Pentalog\BlogBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\Pentalog\BlogBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Pentalog\BlogBundle\Entity\Image 
     */
    public function getImage() {
        return $this->image;
    }


    /**
     * Add categories
     *
     * @param \Pentalog\BlogBundle\Entity\Category $category
     * @return Article
     */
    public function addCategory(\Pentalog\BlogBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Pentalog\BlogBundle\Entity\Category $categories
     */
    public function removeCategory(\Pentalog\BlogBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add comments
     *
     * @param \Pentalog\BlogBundle\Entity\Comment $comment
     * @return Article
     */
    public function addComment(\Pentalog\BlogBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setArticle($this);

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Pentalog\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\Pentalog\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set update_date
     *
     * @param \DateTime $updateDate
     * @return Article
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
    
    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function updateDate() {
        $this->setUpdateDate(new \DateTime());
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}

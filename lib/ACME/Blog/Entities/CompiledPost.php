<?php

namespace ACME\Blog\Entities;

use Webforge\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation AS Serializer;
use Webforge\Common\DateTime\DateTime;

/**
 * Compiled Entity for ACME\Blog\Entities\Post
 * 
 * To change table name or entity repository edit the ACME\Blog\Entities\Post class.
 * @ORM\MappedSuperClass
 */
abstract class CompiledPost {
  
  /**
   * id
   * @Serializer\Expose
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue
   * @Serializer\Type("integer")
   */
  protected $id;
  
  /**
   * author
   * @Serializer\Expose
   * @ORM\ManyToOne(targetEntity="ACME\Blog\Entities\Author", inversedBy="writtenPosts")
   * @Serializer\Type("ACME\Blog\Entities\Author")
   */
  protected $author;
  
  /**
   * revisor
   * @Serializer\Expose
   * @ORM\ManyToOne(targetEntity="ACME\Blog\Entities\Author", inversedBy="revisionedPosts")
   * @Serializer\Type("ACME\Blog\Entities\Author")
   */
  protected $revisor;
  
  /**
   * categories
   * @Serializer\Expose
   * @ORM\ManyToMany(targetEntity="ACME\Blog\Entities\Category", inversedBy="posts")
   * @Serializer\Type("ArrayCollection")
   * @ORM\JoinTable(name="posts2categories", joinColumns={@ORM\JoinColumn(name="posts_id", onDelete="cascade")}, inverseJoinColumns={@ORM\JoinColumn(name="categories_id", onDelete="cascade")})
   */
  protected $categories;
  
  /**
   * tags
   * @Serializer\Expose
   * @ORM\ManyToMany(targetEntity="ACME\Blog\Entities\Tag")
   * @Serializer\Type("ArrayCollection")
   * @ORM\JoinTable(name="posts2tags", joinColumns={@ORM\JoinColumn(name="posts_id", onDelete="cascade")}, inverseJoinColumns={@ORM\JoinColumn(name="tags_id", onDelete="cascade")})
   */
  protected $tags;
  
  /**
   * active
   * @Serializer\Expose
   * @ORM\Column(type="boolean")
   * @Serializer\Type("boolean")
   */
  protected $active;
  
  /**
   * created
   * @Serializer\Expose
   * @ORM\Column(type="WebforgeDateTime")
   * @Serializer\Type("WebforgeDateTime")
   */
  protected $created;
  
  /**
   * modified
   * @Serializer\Expose
   * @ORM\Column(type="WebforgeDateTime", nullable=true)
   * @Serializer\Type("WebforgeDateTime")
   */
  protected $modified;
  
  /**
   * @param integer $id
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }
  
  /**
   * @return integer
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * @param ACME\Blog\Entities\Author $author
   */
  public function setAuthor(Author $author) {
    $this->author = $author;
    $author->addWrittenPost($this);
    return $this;
  }
  
  /**
   * @return ACME\Blog\Entities\Author
   */
  public function getAuthor() {
    return $this->author;
  }
  
  /**
   * @param ACME\Blog\Entities\Author $revisor
   */
  public function setRevisor(Author $revisor = NULL) {
    $this->revisor = $revisor;
    $revisor->addRevisionedPost($this);
    return $this;
  }
  
  /**
   * @return ACME\Blog\Entities\Author
   */
  public function getRevisor() {
    return $this->revisor;
  }
  
  /**
   * @param Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Category> $categories
   */
  public function setCategories(ArrayCollection $categories) {
    $this->categories = $categories;
    return $this;
  }
  
  /**
   * @return Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Category>
   */
  public function getCategories() {
    return $this->categories;
  }
  
  /**
   * @param Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Tag> $tags
   */
  public function setTags(ArrayCollection $tags) {
    $this->tags = $tags;
    return $this;
  }
  
  /**
   * @return Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Tag>
   */
  public function getTags() {
    return $this->tags;
  }
  
  /**
   * @param bool $active
   */
  public function setActive($active) {
    $this->active = $active;
    return $this;
  }
  
  /**
   * @return bool
   */
  public function getActive() {
    return $this->active;
  }
  
  /**
   * @param Webforge\Common\DateTime\DateTime $created
   */
  public function setCreated(DateTime $created) {
    $this->created = $created;
    return $this;
  }
  
  /**
   * @return Webforge\Common\DateTime\DateTime
   */
  public function getCreated() {
    return $this->created;
  }
  
  /**
   * @param Webforge\Common\DateTime\DateTime $modified
   */
  public function setModified(DateTime $modified = NULL) {
    $this->modified = $modified;
    return $this;
  }
  
  /**
   * @return Webforge\Common\DateTime\DateTime
   */
  public function getModified() {
    return $this->modified;
  }
  
  public function addCategory(Category $category) {
    if (!$this->categories->contains($category)) {
        $this->categories->add($category);
        $category->addPost($this);
    }
    return $this;
  }
  
  public function removeCategory(Category $category) {
    if ($this->categories->contains($category)) {
        $this->categories->remove($category);
        $category->removePost($this);
    }
    return $this;
  }
  
  public function hasCategory(Category $category) {
    return $this->categories->contains($category);
  }
  
  public function addTag(Tag $tag) {
    if (!$this->tags->contains($tag)) {
        $this->tags->add($tag);
    }
    return $this;
  }
  
  public function removeTag(Tag $tag) {
    if ($this->tags->contains($tag)) {
        $this->tags->remove($tag);
    }
    return $this;
  }
  
  public function hasTag(Tag $tag) {
    return $this->tags->contains($tag);
  }
  
  public function __construct(Author $author, Author $revisor = NULL) {
    if (isset($author)) {
        $this->setAuthor($author);
    }
    if (isset($revisor)) {
        $this->setRevisor($revisor);
    }
    $this->categories = new ArrayCollection();
    $this->tags = new ArrayCollection();
  }
}

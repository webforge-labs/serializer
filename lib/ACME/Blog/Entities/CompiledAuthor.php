<?php

namespace ACME\Blog\Entities;

use Webforge\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation AS Serializer;

/**
 * Compiled Entity for ACME\Blog\Entities\Author
 * 
 * To change table name or entity repository edit the ACME\Blog\Entities\Author class.
 * @ORM\MappedSuperClass
 */
abstract class CompiledAuthor extends User {
  
  /**
   * writtenPosts
   * @Serializer\Expose
   * @ORM\OneToMany(mappedBy="author", targetEntity="ACME\Blog\Entities\Post")
   * @Serializer\Type("ArrayCollection")
   */
  protected $writtenPosts;
  
  /**
   * revisionedPosts
   * @Serializer\Expose
   * @ORM\OneToMany(mappedBy="revisor", targetEntity="ACME\Blog\Entities\Post")
   * @Serializer\Type("ArrayCollection")
   */
  protected $revisionedPosts;
  
  /**
   * @param Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Post> $writtenPosts
   */
  public function setWrittenPosts(ArrayCollection $writtenPosts) {
    $this->writtenPosts = $writtenPosts;
    return $this;
  }
  
  /**
   * @return Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Post>
   */
  public function getWrittenPosts() {
    return $this->writtenPosts;
  }
  
  /**
   * @param Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Post> $revisionedPosts
   */
  public function setRevisionedPosts(ArrayCollection $revisionedPosts) {
    $this->revisionedPosts = $revisionedPosts;
    return $this;
  }
  
  /**
   * @return Doctrine\Common\Collections\Collection<ACME\Blog\Entities\Post>
   */
  public function getRevisionedPosts() {
    return $this->revisionedPosts;
  }
  
  public function addWrittenPost(Post $writtenPost) {
    if (!$this->writtenPosts->contains($writtenPost)) {
        $this->writtenPosts->add($writtenPost);
    }
    return $this;
  }
  
  public function removeWrittenPost(Post $writtenPost) {
    if ($this->writtenPosts->contains($writtenPost)) {
        $this->writtenPosts->remove($writtenPost);
    }
    return $this;
  }
  
  public function hasWrittenPost(Post $writtenPost) {
    return $this->writtenPosts->contains($writtenPost);
  }
  
  public function addRevisionedPost(Post $revisionedPost) {
    if (!$this->revisionedPosts->contains($revisionedPost)) {
        $this->revisionedPosts->add($revisionedPost);
    }
    return $this;
  }
  
  public function removeRevisionedPost(Post $revisionedPost) {
    if ($this->revisionedPosts->contains($revisionedPost)) {
        $this->revisionedPosts->remove($revisionedPost);
    }
    return $this;
  }
  
  public function hasRevisionedPost(Post $revisionedPost) {
    return $this->revisionedPosts->contains($revisionedPost);
  }
  
  public function __construct($email) {
    parent::__construct($email);
    $this->writtenPosts = new ArrayCollection();
    $this->revisionedPosts = new ArrayCollection();
  }
}

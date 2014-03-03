<?php

namespace ACME\Blog\Entities;

use Webforge\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation AS Serializer;

/**
 * 
 * 
 * this entity was compiled from Webforge\Doctrine\Compiler
 * @ORM\Entity
 * @ORM\Table(name="authors")
 * @Serializer\ExclusionPolicy("all")
 */
class Author extends CompiledAuthor {
}

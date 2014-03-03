<?php

namespace ACME\Blog\Entities;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation AS Serializer;

/**
 * A basic user of the blog
 * 
 * this entity was compiled from Webforge\Doctrine\Compiler
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @Serializer\ExclusionPolicy("all")
 */
class User extends CompiledUser {
}

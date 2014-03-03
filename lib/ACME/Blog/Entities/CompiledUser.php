<?php

namespace ACME\Blog\Entities;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation AS Serializer;

/**
 * Compiled Entity for ACME\Blog\Entities\User
 * 
 * To change table name or entity repository edit the ACME\Blog\Entities\User class.
 * @ORM\MappedSuperclass
 */
abstract class CompiledUser extends \Webforge\Doctrine\Compiler\Test\BaseUserEntity {
  
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
   * email
   * @Serializer\Expose
   * @ORM\Column(length=210)
   * @Serializer\Type("string")
   */
  protected $email;
  
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
   * @param string $email
   */
  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }
  
  /**
   * @return string
   */
  public function getEmail() {
    return $this->email;
  }
  
  public function __construct($email) {
    $this->email = $email;
  }
}

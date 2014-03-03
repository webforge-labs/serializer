<?php

namespace Webforge\Serializer;

use ACME\Blog\Entities\Author;
use ACME\Blog\Entities\Post;
use Webforge\Common\DateTime\DateTime;

class ObjectSerializationVisitorTest extends \Webforge\Code\Test\Base {
  
  public function setUp() {
    parent::setUp();

    $this->builder = new SerializerBuilder;
    $this->serializer = $this->builder->getSerializer();

    $this->author = new Author('p.scheit@ps-webforge.com');
    $this->author->setId(7);

    $this->post = new Post($this->author);
    $this->post->setId(11);
    $this->post->setActive(true);
    $this->post->setCreated($this->now = DateTime::now());

    $this->nowExport = (object) array(
      'date'=>$this->now->format('Y-m-d H:i:s'),
      'timezone'=>$this->now->getTimezone()->getName()
    );
  }

  public function testObjectsAreReturnedAsObjects() {
    $this->assertThatObject($this->serialize($this->post))
      ->property('id')->is($this->equalTo(11))->end()
      ->property('author')->isObject()
        ->property('email')->is('p.scheit@ps-webforge.com')->end()
        ->property('id')->is($this->equalTo(7))->end()
        ->property('writtenPosts')->isArray()->end()
        ->property('revisionedPosts')->isArray()->end()
      ->end()
      ->property('active')->is($this->identicalTo(true))->end()
      ->property('created')->is($this->equalTo($this->nowExport))->end();
    ;
  }

  protected function serialize($object) {
    return $this->serializer->serialize($object, 'json');
  }
}

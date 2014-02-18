<?php

namespace Webforge\Serializer;

class SerializerBuilderTest extends \Webforge\Code\Test\Base {
  
  public function setUp() {
    $this->chainClass = __NAMESPACE__ . '\\SerializerBuilder';
    parent::setUp();

    $this->builder = new $this->chainClass;
  }

  public function testBuilderReturnsAJMSSerializer() {
    $this->assertInstanceOf('JMS\Serializer\Serializer', $this->builder->getSerializer());
  }
}

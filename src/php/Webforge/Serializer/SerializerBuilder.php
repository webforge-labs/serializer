<?php

namespace Webforge\Serializer;

class SerializerBuilder {

  public function getSerializer() {
    return \JMS\Serializer\SerializerBuilder::create()
      ->addDefaultHandlers()
      ->configureHandlers(function(\JMS\Serializer\Handler\HandlerRegistry $registry) {
        $registry->registerSubscribingHandler(new DateTimeHandler());
      })
      ->setPropertyNamingStrategy($namingStrategy = new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy())
      ->addDefaultSerializationVisitors()
      ->setSerializationVisitor('json', new ObjectSerializationVisitor($namingStrategy))
      ->addDefaultDeSerializationVisitors()
      ->build();
  }
}

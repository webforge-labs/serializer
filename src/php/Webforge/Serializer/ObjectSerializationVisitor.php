<?php

namespace Webforge\Serializer;

use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Context;
use Webforge\Common\ArrayUtil as A;
use JMS\Serializer\Metadata\ClassMetadata;

class ObjectSerializationVisitor extends JsonSerializationVisitor {

  // Does not json encode by default
  public function getResult() {
    return (object) $this->getRoot();
  }

  /*
  public function visitArray($data, array $type, Context $context) {
    $result = parent::visitArray($data, $type, $context);

    if (A::isAssoc($result)) {
      $result = (object) $result;
    }

    return $result;
  }
  */

  public function endVisitingObject(ClassMetadata $metadata, $data, array $type, Context $context) {
    $result = parent::endVisitingObject($metadata, $data, $type, $context);

    return (object) $result;
  }
}

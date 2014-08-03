<?php

namespace Webforge\ProjectStack\Serializer;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\Context;
use DateTimeZone;
use Webforge\Common\DateTime\DateTime;

class DateTimeHandler implements SubscribingHandlerInterface {

  public static function getSubscribingMethods() {
    return array(
      array(
        'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
        'format' => 'json',
        'type' => 'WebforgeDateTime',
        'method' => 'serializeDateTimeToJson',
      ),

      array(
        'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
        'format' => 'json',
        'type' => 'WebforgeDateTime',
        'method' => 'deserializeDateTimeFromJson',
      ),
    );
  }

  public function serializeDateTimeToJson(JsonSerializationVisitor $visitor, DateTime $date, array $type, Context $context) {
    return (object) array(
      'date'=>$date->format('Y-m-d H:i:s'),
      'timezone'=>$date->getTimezone()->getName()
    );
  }

  public function deserializeDateTimeFromJson(JsonDeserializationVisitor $visitor, $json, array $type, Context $context) {
    $json = (object) $json;
    return DateTime::parse('Y-m-d H:i:s', $json->date, new DateTimeZone($json->timezone));
  }
}

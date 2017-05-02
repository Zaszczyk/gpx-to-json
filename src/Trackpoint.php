<?php

namespace MateuszBlaszczyk\GpxToJson;


class Trackpoint implements \Serializable
{
    public $latitude;

    public $longitude;

    public $altitude;

    public $timestamp;

    public $distance;

    public function isComplete($obligatoryAltitude = true)
    {
        if (($obligatoryAltitude && $this->latitude && $this->longitude && $this->altitude && isset($this->distance))
            ||
            ($obligatoryAltitude === false && $this->latitude && $this->longitude && isset($this->distance))) {
            return true;
        }
        return false;
    }

    public function serialize()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'altitude' => $this->altitude,
            'distance' => $this->distance,
            'timestamp' => $this->timestamp,
        ];
    }

    public function unserialize($serialized)
    {
        $item = new Trackpoint();
        $item->latitude = $serialized['latitude'];
        $item->longitude = $serialized['longitude'];
        $item->altitude = $serialized['altitude'];
        $item->distance = $serialized['distance'];
        $item->timestamp = $serialized['timestamp'];

        return $item;
    }
}
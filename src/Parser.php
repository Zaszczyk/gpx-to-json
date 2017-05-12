<?php

namespace MateuszBlaszczyk\GpxToJson;


use SimpleXMLElement;

class Parser
{
    protected $xml;

    protected $vt;

    public function __construct($xml)
    {
        $this->xml = $xml;
        $this->vt = new ValueTransformer();
        $this->distanceCalculator = new DistanceCalculator();
    }

    public function parse($obligatoryAltitude = true)
    {
        $results = [];

        /**
         * {"altitude":112.5,"latitude":52.231231,"type":"start","timestamp":0,"longitude":21.011354}
         */

        /** @var SimpleXMLElement $gpx */
        $gpx = simplexml_load_string($this->xml);

        if (!isset($gpx->trk->trkseg)) {
            return [];
        }

        /** @var SimpleXMLElement $trkpt */
        foreach ($gpx->trk->trkseg->children() as $key => $trkpt) {
            $trackpoint = new Trackpoint();
            $trackpoint->latitude = $this->vt->substrGPSCoordinate($trkpt->attributes()['lat']);
            $trackpoint->longitude = $this->vt->substrGPSCoordinate($trkpt->attributes()['lon']);
            $trackpoint->altitude = $this->vt->roundAltitude((string)$trkpt->ele);

            if (isset($timestamp)) {
                $trackpoint->timestamp = $this->vt->transformTime($trkpt->time) - $timestamp;
            } else {
                $timestamp = $this->vt->transformTime($trkpt->time);
                $trackpoint->timestamp = 0;
            }
            if (count($results) == 0) {
                $trackpoint->distance = 0.0;
            } elseif (isset($trackpoint->longitude) && isset($trackpoint->latitude)) {
                $lastTrackpoint = $results[count($results) - 1];
                $trackpoint->distance = $lastTrackpoint->distance + $this->vt->roundDistance($this->distanceCalculator->countDistanceBetween2Trackpoints($trackpoint, $lastTrackpoint));
                //var_dump($this->vt->roundDistance($this->distanceCalculator->countDistanceBetween2Trackpoints($trackpoint, $lastTrackpoint)));
            }

            if ($trackpoint->isComplete($obligatoryAltitude)) {
                $results[] = $trackpoint;
            }
        }

        foreach ($results as $key => &$t) {
            $results[$key] = $t->serialize();
        }

        return $results;
    }

    public function getJson()
    {
        $results = $this->parse();
        return json_encode($results);
    }


}
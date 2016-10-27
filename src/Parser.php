<?php
namespace MateuszBlaszczyk\GpxToJson;


use XMLReader;

class Parser
{
    protected $xml;

    protected $vt;

    public function __construct($xml)
    {
        $this->xml = $xml;
        $this->vt = new ValueTransformer();
    }

    public function parse()
    {
        $results = [];

        /**
         * {"altitude":112.5,"latitude":52.231231,"type":"start","timestamp":0,"longitude":21.011354}
         */

        $xmlReader = new XMLReader;
        $xmlReader->xml($this->xml);
        $timestamp = $this->getStartTimestamp($xmlReader);

        $trackpoint = new Trackpoint();
        while ($xmlReader->read()) {
            if ($xmlReader->nodeType == XMLReader::ELEMENT) {

                switch ($xmlReader->name) {
                    case 'LatitudeDegrees':
                        $node = $xmlReader->expand();
                        $trackpoint->latitude = $this->vt->substrGPSCoordinate($node->nodeValue);
                        break;
                    case 'LongitudeDegrees':
                        $node = $xmlReader->expand();
                        $trackpoint->longitude = $this->vt->substrGPSCoordinate($node->nodeValue);
                        break;
                    case 'AltitudeMeters':
                        $node = $xmlReader->expand();
                        $trackpoint->altitude = $this->vt->roundAltitude($node->nodeValue);
                        break;
                    case 'DistanceMeters':
                        $node = $xmlReader->expand();
                        if ($xmlReader->depth > 4) {
                            $trackpoint->distance = $this->vt->roundDistance($node->nodeValue);
                        }
                        break;
                    case 'Time':
                        $node = $xmlReader->expand();
                        $trackpoint->timestamp = $this->vt->transformTime($node->nodeValue) - $timestamp;
                        break;
                }
            }

            if ($trackpoint->isComplete()) {
                $results[] = $trackpoint->serialize();
                unset($trackpoint);
                $trackpoint = new Trackpoint();
            }
        }

        return $results;
    }

    public function getJson()
    {
        $results = $this->parse();
        return json_encode($results);
    }

    public function getStartTimestamp(XMLReader $xmlReader)
    {
        $timeString = false;
        while ($xmlReader->read()) {
            if ($xmlReader->nodeType == XMLReader::ELEMENT && $xmlReader->name == 'Lap') {
                $timeString = $xmlReader->getAttribute('StartTime');
                break;
            }
        }

        if (!$timeString) {
            return false;
        }

        $timestamp = $this->vt->transformTime($timeString);
        return $timestamp;
    }

}
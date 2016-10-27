<?php
namespace MateuszBlaszczyk\GpxToJson;


use SimpleXMLElement;
use XMLReader;

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

    public function parse()
    {
        $results = [];

        /**
         * {"altitude":112.5,"latitude":52.231231,"type":"start","timestamp":0,"longitude":21.011354}
         */

        /** @var SimpleXMLElement $gpx */
        $gpx = simplexml_load_string($this->xml);
        /* foreach ($results as $child){
             var_dump($child->getName());
             echo "a\r\n";
         }*/

        $trackpoint = new Trackpoint();
        /** @var SimpleXMLElement $trkpt */
        foreach ($gpx->trk->trkseg->children() as $key => $trkpt) {

            $trackpoint->latitude = $this->vt->substrGPSCoordinate($trkpt->attributes()['lat']);
            $trackpoint->longitude = $this->vt->substrGPSCoordinate($trkpt->attributes()['lon']);
            $trackpoint->altitude = $this->vt->roundAltitude($trkpt->ele);

            if (isset($timestamp)) {
                $trackpoint->timestamp = $this->vt->transformTime($trkpt->time) - $timestamp;
            } else {
                $timestamp = $trackpoint->timestamp = $this->vt->transformTime($trkpt->time);
            }
            if (count($results) == 0) {
                $trackpoint->distance = 0;
            } elseif (isset($trackpoint->longitude) && isset($trackpoint->latitude)) {
                $trackpoint->distance = $this->distanceCalculator->countDistanceBetween2Trackpoints($trackpoint, $results[count($results) - 1]);
            }

            if ($trackpoint->isComplete()) {
                $results[] = clone $trackpoint;
            }
            var_dump($trackpoint);
        }

        return $results;
    }

    public function getJson()
    {
        $results = $this->parse();
        return json_encode($results);
    }


}
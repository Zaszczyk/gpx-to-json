<?php
use MateuszBlaszczyk\GpxToJson\Parser;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 25.04.2016
 * Time: 00:08
 */
class ParserTest extends PHPUnit_Framework_TestCase
{

    public function getDataFromGpxFile($filename)
    {
        return file_get_contents(__DIR__ . '/data/' . $filename);
    }

    public function testParseGpxGpx()
    {
        $parser = new Parser($this->getDataFromGpxFile('gpx.gpx'));
        $results = $parser->parse();
        $this->assertEquals(589, count($results));

        foreach ($results as $r) {
            $this->assertEquals(5, count($r));
        }

        $this->assertArraySubset([
            'latitude' => '51.77611',
            'longitude' => '19.470749',
            'altitude' => '213.4',
            'distance' => '0',
            'timestamp' => '0'
        ], $results[0]);

        $this->assertArraySubset([
            'latitude' => '51.776109',
            'longitude' => '19.470731',
            'altitude' => '213.4',
            'distance' => '0.00124',
            'timestamp' => '1'
        ], $results[1]);

        $this->assertArraySubset([
            'latitude' => '51.776107',
            'longitude' => '19.470713',
            'altitude' => '213.4',
            'distance' => '0.00249',
            'timestamp' => 2
        ], $results[2]);

        /*$this->assertArraySubset([
            'latitude' => '51.771882',
            'longitude' => '19.463718',
            'altitude' => '212.9',
            'distance' => '0.92689',
            'timestamp' => 596
        ], $results[588]);*/

        $this->assertEquals('51.771882', $results[588]['latitude']);
        $this->assertEquals('19.463718', $results[588]['longitude']);
        $this->assertEquals('212.9', $results[588]['altitude']);
        $this->assertEquals('0.92689', (string)$results[588]['distance']);
        $this->assertEquals(596, $results[588]['timestamp']);
    }

    public function testParseGpxLong()
    {
        $parser = new Parser($this->getDataFromGpxFile('long.gpx'));
        $results = $parser->parse();
        $this->assertEquals(8036, count($results));

        foreach ($results as $r) {
            $this->assertEquals(5, count($r));
        }
        $this->assertArraySubset([
            'latitude' => '51.651836',
            'longitude' => '19.271491',
            'altitude' => '188.6',
            'distance' => '0',
            'timestamp' => '0'
        ], $results[0]);


        print_r($results[8035]);
        $this->assertArraySubset([
            'latitude' => '51.651524',
            'longitude' => '19.271405',
            'altitude' => '187.6',
            'distance' => '0.03519',
            'timestamp' => '1'
        ], $results[1]);

        $this->assertArraySubset([
            'latitude' => '51.651212',
            'longitude' => '19.271323',
            'altitude' => '187.3',
            'distance' => '0.07034',
            'timestamp' => 2
        ], $results[2]);


        $this->assertEquals('50.691631', $results[8035]['latitude']);
        $this->assertEquals('17.951848', $results[8035]['longitude']);
        $this->assertEquals('165.8', $results[8035]['altitude']);
        $this->assertEquals('173.70902', (string)$results[8035]['distance']);
        $this->assertEquals(8035, $results[8035]['timestamp']);
    }
}

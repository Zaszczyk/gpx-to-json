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


    /**
     * @group xml1
     */
    public function testParseXml1()
    {
        $parser = new Parser($this->getDataFromGpxFile('gpx.gpx'));
        $results = $parser->parse();
        $this->assertEquals(34, count($results));

        foreach ($results as $r) {
            $this->assertEquals(5, count($r));
        }

        $this->assertArraySubset([
            'latitude' => '51.772699',
            'longitude' => '19.422868',
            'altitude' => '202.18',
            'distance' => '0.0',
            'timestamp' => '0'
        ], $results[0]);

        $this->assertArraySubset([
            'latitude' => '51.772699',
            'longitude' => '19.422868',
            'altitude' => '202.18',
            'distance' => '0.0',
            'timestamp' => '5'
        ], $results[1]);

        $this->assertArraySubset([
            'latitude' => '51.772670',
            'longitude' => '19.422824',
            'altitude' => '202.09',
            'distance' => '0.00439',
            'timestamp' => '10'
        ], $results[2]);
    }


    /*public function testParseXml2()
    {
        $parser = new Parser($this->getXml2());
        $results = $parser->parse();
        $this->assertEquals(36, count($results));

        foreach ($results as $r) {
            $this->assertEquals(5, count($r));
        }

        $this->assertArraySubset([
            'latitude' => '51.772656',
            'longitude' => '19.422962',
            'altitude' => '284.01',
            'distance' => '0.0',
            'timestamp' => '0'
        ], $results[0]);

        $this->assertArraySubset([
            'latitude' => '51.772656',
            'longitude' => '19.422962',
            'altitude' => '284.01',
            'distance' => '0.0',
            'timestamp' => '5'
        ], $results[1]);

        $this->assertArraySubset([
            'latitude' => '51.772656',
            'longitude' => '19.422962',
            'altitude' => '284.01',
            'distance' => '0.0',
            'timestamp' => '9'
        ], $results[2]);

        $this->assertArraySubset([
            'latitude' => '51.772942',
            'longitude' => '19.422948',
            'altitude' => '193.75',
            'distance' => '0.36918',
            'timestamp' => '45'
        ], $results[35]);
    }*/

    /**
     * @group xml1
     */
    /*public function testParseXml3()
    {
        $parser = new Parser($this->getXml3());
        $results = $parser->parse();
        file_put_contents('json.json', json_encode($results));
        $this->assertEquals(34, count($results));

        foreach ($results as $r) {
            $this->assertEquals(5, count($r));
        }

        $this->assertArraySubset([
            'latitude' => '51.772699',
            'longitude' => '19.422868',
            'altitude' => '202.18',
            'distance' => '0.0',
            'timestamp' => '0'
        ], $results[0]);

        $this->assertArraySubset([
            'latitude' => '51.772699',
            'longitude' => '19.422868',
            'altitude' => '202.18',
            'distance' => '0.0',
            'timestamp' => '5'
        ], $results[1]);

        $this->assertArraySubset([
            'latitude' => '51.772670',
            'longitude' => '19.422824',
            'altitude' => '202.09',
            'distance' => '0.00439',
            'timestamp' => '10'
        ], $results[2]);
    }

  */
}

<?php
use MateuszBlaszczyk\GpxToJson\ValueTransformer;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 25.04.2016
 * Time: 00:08
 */
class ValueTransformerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function testSubstrGPSCoordinateValid1()
    {
        $vt = new ValueTransformer();
        $result = $vt->substrGPSCoordinate('51.77269923686981');
        $this->assertEquals('51.772699', $result);
    }

    public function testSubstrGPSCoordinateValid2()
    {
        $vt = new ValueTransformer();
        $result = $vt->substrGPSCoordinate('19.422850728034973');
        $this->assertEquals('19.422850', $result);
    }

    public function testSubstrGPSCoordinateValid3()
    {
        $vt = new ValueTransformer();
        $result = $vt->substrGPSCoordinate('192.123456');
        $this->assertEquals('192.123456', $result);
    }

    public function testSubstrGPSCoordinateValid4()
    {
        $vt = new ValueTransformer();
        $result = $vt->substrGPSCoordinate('192.1234567');
        $this->assertEquals('192.123456', $result);
    }

    public function testSubstrGPSCoordinateValid5()
    {
        $vt = new ValueTransformer();
        $result = $vt->substrGPSCoordinate('192.12');
        $this->assertEquals('192.12', $result);
    }

    public function testRoundDistanceMetersToKilometers1()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('0.0');
        $this->assertEquals('0.0', $result);
    }

    public function testRoundDistanceMetersToKilometers2()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('0.00');
        $this->assertEquals('0.00', $result);
    }

    public function testRoundDistanceMetersToKilometers3()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('0.000');
        $this->assertEquals('0.000', $result);
    }

    public function testRoundDistanceMetersToKilometers4()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('0.999');
        $this->assertEquals('0.00100', $result);
    }

    public function testRoundDistanceMetersToKilometers5()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('0');
        $this->assertEquals('0.00', $result);
    }

    public function testRoundDistanceMetersToKilometers6()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('8.969829090263627');
        $this->assertEquals('0.00897', $result);
    }

    public function testRoundDistanceMetersToKilometers7()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistanceMetersToKilometers('1');
        $this->assertEquals('0.001', $result);
    }

    public function testRoundDistance1()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundDistance('0.00123');
        $this->assertEquals('0.00123', $result);
    }

    public function testRoundAltitude1()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundAltitude('0.999');
        $this->assertEquals('1.00', $result);
    }

    public function testRoundAltitude2()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundAltitude('158.999');
        $this->assertEquals('159.00', $result);
    }

    public function testRoundAltitude3()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundAltitude('158.9');
        $this->assertEquals('158.90', $result);
    }

    public function testRoundAltitude4()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundAltitude('0.99');
        $this->assertEquals('0.99', $result);
    }

    public function testRoundAltitude5()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundAltitude('202.0');
        $this->assertEquals('202.00', $result);
    }

    public function testRoundAltitude6()
    {
        $vt = new ValueTransformer();
        $result = $vt->roundAltitude('212.9');
        $this->assertEquals(212.9, $result);
    }

    public function testTransformTime1()
    {
        $vt = new ValueTransformer();
        $result = $vt->transformTime('2016-04-24T22:29:12.000+02:00');
        $this->assertEquals('1461529752', $result);
    }

    public function testTransformTime2()
    {
        $vt = new ValueTransformer();
        $result = $vt->transformTime('');
        $this->assertEquals(null, $result);
    }
}

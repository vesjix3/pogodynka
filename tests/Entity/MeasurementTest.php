<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class MeasurementTest extends TestCase
{
    public static  function  dataGetFahrenheit():array
    {


        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['10', '50'],
            ['-10', '14'],
            ['15.5', '59.9'],
            ['-15.5', '4.1'],
            ['30', '86'],
            ['1.5', '34.7'],
            ['-5', '23'],
        ];
    }
        #[DataProvider('dataGetFahrenheit')]
        public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void {$forecast = new Forecast();
            $forecast = new Forecast();
            $forecast->setTemperature((float) $celsius);
            $this->assertEqualsWithDelta((float) $expectedFahrenheit, $forecast->getFahrenheit(), 0.01);
//            ai pomoglo mi z ostatnia linia, dodalam ta delte bo bez niej byl blad zaokraglenia i nie przechodzil test
        }

}

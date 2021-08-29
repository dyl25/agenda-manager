<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{

    public function test_time_is_well_formated() {
        $timeStrings = [
            830 => '08:30',
            900 => '09:00',
            500 => '05:00',
            10 => '00:10',
            1 => '00:01'
        ];

        foreach ($timeStrings as $timeString => $expectedVal) {
            $this->assertEquals($expectedVal, formatStringTime($timeString));
        }
    }

    public function test_time_string_are_correctly_convert()
    {

        $timeStrings = [
            '8:30' => '830',
            '8:60' => '900',
            '24:10' => '10',
            '24:01' => '1',
        ];

        foreach ($timeStrings as $timeString => $expectedVal) {
            $this->assertEquals($expectedVal, converStringTime($timeString));
        }

    }
}

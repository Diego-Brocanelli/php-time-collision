<?php

declare(strict_types=1);

namespace Tests;

use DateTime;
use Time\Collision;
use Time\WeekDay;

class CollisionRecalculateDefaultAllDaysTest extends TestCase
{
    /** @test */
    public function defaultToAllDays()
    {
        // DEFAULT
        $object = new Collision('2020-11-01 00:00:00', '2020-11-03 08:30:00');
        $object->allowPeriod('08:00', '09:00');

        // das 8 as 9 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 8:30 do terceiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result += $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());

        // + ALL DAYS
        $object->allowAllDays();

        // das 8 as 9 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 8:30 do terceiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result += $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());
    }

    /** @test */
    public function defaultToDay()
    {
        // DEFAULT
        $object = new Collision('2020-11-01 00:00:00', '2020-11-03 08:30:00');
        $object->allowPeriod('08:00', '09:00');

        // das 8 as 9 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 8:30 do terceiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result += $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());

        // + DAY
        $object->allowDay(WeekDay::MONDAY);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());
    }

    /** @test */
    public function defaultToPeriod()
    {
        // DEFAULT
        $object = new Collision('2020-11-01 00:00:00', '2020-11-03 08:30:00');
        $object->allowPeriod('08:00', '09:00');

        // das 8 as 9 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 8:30 do terceiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result += $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());

        // + PERIOD
        $object->allowPeriod('10:00', '11:00');

        // das 8 as 9 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);

        // das 10 as 11 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 10:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 10 as 11 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 10:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 8:30 do terceiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result += $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());
    }

    /** @test */
    public function defaultToDate()
    {
        // DEFAULT
        $object = new Collision('2020-11-01 00:00:00', '2020-11-03 08:30:00');
        $object->allowPeriod('08:00', '09:00');

        // das 8 as 9 do primeiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-01 08:00:00'));
        $end = $start + 60;
        $result = $this->period("{$start}..{$end}", 0);

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-02 08:00:00'));
        $end = $start + 60;
        $result += $this->period("{$start}..{$end}", 0);

        // das 8 as 8:30 do terceiro dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result += $this->period("{$start}..{$end}", 0);
        
        $this->assertEquals($result, $object->minutes()->allowed());

        // + DATE
        $object->allowDate('2020-11-03');

        // das 8 as 9 do segundo dia
        $start = $this->minutesBeetwen(new DateTime('2020-11-01 00:00:00'), new DateTime('2020-11-03 08:00:00'));
        $end = $start + 30;
        $result = $this->period("{$start}..{$end}", 0);

        $this->assertEquals($result, $object->minutes()->allowed());
    }
}

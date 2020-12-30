<?php

declare(strict_types=1);

namespace Tests;

use Time\WeekDay;
use Time\Exceptions\InvalidTimeException;
use Time\Exceptions\InvalidWeekDayException;

class WeekDayTest extends TestCase
{
    /** @test */
    public function constants()
    {
        $this->assertEquals(0, WeekDay::SUNDAY);
        $this->assertEquals(1, WeekDay::MONDAY);    
        $this->assertEquals(2, WeekDay::TUESDAY);   
        $this->assertEquals(3, WeekDay::WEDNESDAY); 
        $this->assertEquals(4, WeekDay::THURSDAY);  
        $this->assertEquals(5, WeekDay::FRIDAY);    
        $this->assertEquals(6, WeekDay::SATURDAY);  
        $this->assertEquals(7, WeekDay::ALL_DAYS);  
    }

    /** @test */
    public function constructor()
    {
        $object = new WeekDay(WeekDay::MONDAY);
        $this->assertEquals(WeekDay::MONDAY, $object->day());
    }

    /** @test */
    public function constructorException()
    {
        $this->expectException(InvalidWeekDayException::class);
        $this->expectExceptionMessage('The day must be 0 to 7, or use Week::???');
        
        new WeekDay(8);
    }

    /** @test */
    public function withPeriodSyntaxException()
    {
        $this->expectException(InvalidTimeException::class);

        $object = new WeekDay(WeekDay::MONDAY);
        $object->withPeriod('00:00', '00,00');
    }

    /** @test */
    public function withPeriodException()
    {
        $this->expectException(InvalidTimeException::class);
        $this->expectExceptionMessage('The end time must be greater than the start time of the period');
        
        $object = new WeekDay(WeekDay::MONDAY);
        $object->withPeriod('09:00', '08:00');
    }
}

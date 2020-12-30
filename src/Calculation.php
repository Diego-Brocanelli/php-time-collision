<?php

declare(strict_types=1);

namespace Time;

use DateTime;

class Calculation
{
    protected Params $params;

    protected Minutes $minutes;

    protected DateTime $rangeStart;

    protected DateTime $rangeEnd;

    public function __construct(Params $params, DateTime $start, DateTime $end)
    {
        $this->rangeStart = $start;
        $this->rangeEnd   = $end;
        $this->params     = $params;
        $this->minutes    = new Minutes($this->rangeStart, $this->rangeEnd);
    }

    private function allowSpecificDays(): void
    {
        $specificDays = $this->params->getDates();
        $weekDays     = $this->params->getWeekDays();

        foreach ($specificDays as $dateObject) {
            $weekDay = $dateObject->dayOfWeek();
            if (isset($weekDays[$weekDay]) === false) {
                $dayObject = new WeekDay($weekDay);
                $weekDays[$weekDay] = $dayObject;
            }

            $this->allowPeriods($dateObject, $weekDays[$weekDay]);
        }
    }

    private function allowWeekDays(): void
    {
        $weekDaysList = $this->params->getWeekDays();
        $disabledDays = $this->params->getDisabledDates();
        $daysChunks   = $this->minutes->chunks()->days();

        foreach ($daysChunks as $minute => $day) {
            $day = new Date((string)$day->format('Y-m-d'));

            // marca somente dias liberados
            $disabledIndex = $day->dayString();
            if (isset($disabledDays[$disabledIndex]) === true) {
                continue;
            }

            // marca somente dias da semana liberados
            $weekDay = $day->dayOfWeek();
            if (isset($weekDaysList[$weekDay]) === true) {
                $current = clone $this->rangeStart;
                $current->modify("+ {$minute} minutes");
                $dayObject = new Date($current->format('Y-m-d H:i'));
                $this->allowPeriods($dayObject, $weekDaysList[$weekDay]);
            }
        }
    }

    /**
     * Marca os períodos dos dias liberados para que possam
     * ser usados para preenchimento.
     */
    private function allowPeriods(Date $specificDay, WeekDay $weekDay): void
    {
        $this->resolveDefaultPeriods($weekDay);

        $periods = $weekDay->periods();

        foreach ($periods as $times) {
            $periodStart = explode(':', $times[0]);
            $periodEnd = explode(':', $times[1]);

            $open = $specificDay->day();
            $open->setTime((int)$periodStart[0], (int)$periodStart[1]);

            $close = $specificDay->day();
            $close->setTime((int)$periodEnd[0], (int)$periodEnd[1]);

            // not work minutes
            $this->minutes->mark($open, $close, Minutes::ALLOWED);
        }
    }

    /**
     * Especifica os períodos que serão usados para o
     * dia da semana especificado.
     * Caso não tenha sido setado em WeekDay::withPeriod()
     * usará o padrão setado com Collision::allowPeriod.
     */
    private function resolveDefaultPeriods(WeekDay $day): void
    {
        $day->removeDefaults();

        if ($day->periods() !== []) {
            return;
        }

        $day->withPeriods($this->params->getDefaultPeriods(), true);
    }

    public function populateRange(): Minutes
    {
        $this->allowSpecificDays();
        $this->allowWeekDays();

        foreach ($this->params->getFills() as $times) {
            $this->markFilled($times[0], $times[1]);
        }

        foreach ($this->params->getCumulativeFills() as $times) {
            $this->markFilled($times[0], $times[1], true);
        }

        return $this->minutes;
    }

    /**
     * Marca efetivamente o período especificado como preenchido.
     * @param \DateTime $start
     * @param \DateTime $end
     * @param bool $cumulative
     */
    private function markFilled(DateTime $start, DateTime $end, bool $cumulative = false): void
    {
        if ($cumulative === true) {
            $this->minutes->markCumulative($start, $end, Minutes::FILLED);
            return;
        }

        $this->minutes->mark($start, $end, Minutes::FILLED);
    }
}

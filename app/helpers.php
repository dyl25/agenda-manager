<?php

/**
 * Convert a string time to the correct format
 *
 * @param string $time
 * @return string
 */
function converStringTime(string $time, string $separator = null): string
{
    if (\strlen($time) === 3) {
        $hours = (int) \substr($time, 0, 1);
        $minutes = (int) \substr($time, 1);
    } else {
        $hours = (int) \substr($time, 0, 2);
        $minutes = (int) \substr($time, 2);
    }

    if ($minutes < 60 && $hours < 24) {
        return $time;
    }

    $newMinutes = $minutes % 60;

    $totalHours = $hours % 24 + \intdiv($minutes, 60);

    $minutesStr = \strval($newMinutes);
    $hoursStr = \strval($totalHours);

    if (\strlen($minutesStr) === 1) {
        $minutesStr = '0' . $minutesStr;
    }

    if ($separator) {
        return $hoursStr . $separator . $minutesStr;
    }

    return $hoursStr . $minutesStr;
}

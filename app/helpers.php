<?php

function formatStringTime(int $time)
{
    $strTime = \strval($time);

    if (\strlen($strTime) < 4) {
        $nbRepeat = 4 - \strlen($strTime);
        $strTime = \str_repeat('0', $nbRepeat) . $strTime;
    }

    return \substr_replace($strTime, ':', 2, 0);
}

/**
 * Convert a string time to the correct format
 *
 * @param string $time
 * @return string
 */
function converStringTime(string $time, string $separator = null): string
{
    $charPos = \strpos($time, ':');

    $hours =  (int) \substr($time, 0, $charPos);
    $minutes =  (int) \substr($time, $charPos + 1);

    if ($minutes >= 60 || $hours >= 24) {
        $hours = $hours % 24 + \intdiv($minutes, 60);

        $minutes = $minutes % 60;
    }

    $minutesStr = \strval($minutes);
    $hoursStr = '';

    if ($hours !== 0) {
        $hoursStr = \strval($hours);
    }

    if (\strlen($minutesStr) === 1 && $hours !== 0) {
        $minutesStr = '0' . $minutesStr;
    }

    if ($separator) {
        return $hoursStr . $separator . $minutesStr;
    }

    return $hoursStr . $minutesStr;
}

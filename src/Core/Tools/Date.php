<?php

namespace AnexusPHP\Core\Tools;

use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use DateTime;
use DateTimeZone;
use Exception;
use IntlDateFormatter;

class Date
{
    public static function formatToTime($format, $strTime)
    {
        $dateTime = \DateTime::createFromFormat($format, $strTime);
        if (is_object($dateTime) && $dateTime->format($format) == $strTime) {
            return $dateTime->getTimestamp();
        } else {
            return false;
        }
    }

    public static function showFullDate($date)
    {
        $date = explode('-', date('d-m-Y-H:i', strtotime($date)));
        $date[1] = self::showMonth($date[1]);
        $date = "{$date[0]} de {$date[1]} de {$date[2]} - {$date[3]}";
        return $date;
    }

    public static function timeConverter($time, RegionCountryEntity $country, bool $hour = false)
    {
        $arr = explode(' ', $time);
        $format = '';
        if (count($arr) > 1) {
            $format = 'Y-m-d H:i:s';
        } else {
            $format = 'Y-m-d';
        }
        $localTime = DateTime::createFromFormat($format, $time, new DateTimeZone('America/Sao_Paulo'));

        $formatter = new IntlDateFormatter($country->getLocale(), IntlDateFormatter::NONE, IntlDateFormatter::NONE, $country->getTimeZone(), IntlDateFormatter::GREGORIAN, $hour ? $country->getDateHourFormat() :  $country->getDateFormat());

        return $formatter->format($localTime);
    }

    public static function showMonth($month)
    {
        $months = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        if (!isset($months[$month])) {
            throw new \Exception('Ocorreu um erro ao descrever o mês.');
        }

        return $months[$month];
    }

    public static function showMonthLess($month, $lowercase = false)
    {
        $months = array(
            '01' => 'Jan',
            '02' => 'Fev',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Set',
            '10' => 'Out',
            '11' => 'Nov',
            '12' => 'Dez'
        );

        if (!isset($months[$month])) {
            throw new \Exception('Ocorreu um erro ao descrever o mês.');
        }

        if ($lowercase) {
            return mb_convert_case($months[$month], MB_CASE_LOWER);
        }

        return $months[$month];
    }

    public static function showDayWeek($day, $fullname = false)
    {
        $daysWeek = array(
            0 => 'Domingo',
            1 => 'Segunda' . ($fullname ? '-feira' : ''),
            2 => 'Terça' . ($fullname ? '-feira' : ''),
            3 => 'Quarta' . ($fullname ? '-feira' : ''),
            4 => 'Quinta' . ($fullname ? '-feira' : ''),
            5 => 'Sexta' . ($fullname ? '-feira' : ''),
            6 => 'Sábado'
        );
        if (!isset($daysWeek[$day])) {
            throw new \Exception('Ocorreu um erro ao descrever o dia da semana pequeno.');
        }

        return $daysWeek[$day];
    }

    public static function showDayWeekLess($day)
    {
        $daysWeek = array(
            0 => 'Dom',
            1 => 'Seg',
            2 => 'Ter',
            3 => 'Qua',
            4 => 'Qui',
            5 => 'Sex',
            6 => 'Sáb'
        );
        if (!isset($daysWeek[$day])) {
            throw new \Exception('Ocorreu um erro ao descrever o dia da semana pequeno.');
        }

        return $daysWeek[$day];
    }

    /**
     * @param string $date
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function toUs($date, $format)
    {
        $time = self::formatToTime($format, $date);
        if (date($format, $time) != $date) {
            throw new \Exception('Data inválida');
        }
        return date('Y-m-d', $time);
    }

    /**
     * Undocumented function
     *
     * @param string $str
     * @return double
     */
    public static function strTimeToHours($str)
    {
        $arr = explode(':', $str);
        if(count($arr)==2){
            $arr[] = '00';
        }
        if (count($arr) != 3) {
            throw new Exception('String do horário '.$str.' é inválido!');
        }

        $h = intval($arr[0]);
        $m = intval($arr[1]);
        $s = intval($arr[2]);

        $totalHours = doubleval($h) + (doubleval($m) / doubleval(60)) + (doubleval($s) / (doubleval(60) * doubleval(60)));

        return doubleval(round($totalHours, 2));
    }

    /**
     * Undocumented function
     *
     * @param string $strA
     * @param string $strB
     * @return double
     */
    public static function diffHoursByStr($strA, $strB)
    {
        $timeA = self::strTimeToHours($strA);
        $timeB = self::strTimeToHours($strB);

        $diff = 0;
        if ($timeB < $timeA) {
            $diff = (24 - $timeA) + $timeB;
        } else {
            $diff = $timeB - $timeA;
        }

        return $diff;
    }

    public static function diffHoursByDateFull($a, $b)
    {
        $diff = doubleval(strtotime($b)) - doubleval(strtotime($a));
        return abs(doubleval($diff / (60 * 60)));
    }

    public static function descriptionDiff($hours, $dayText = 'dia(s)', $hourText = 'h', $minText = 'min', $secText = 's')
    {
        $d = floor($hours / 24);
        $rest = abs($hours - ($d * 24));
        $h = floor($rest);
        $rest = abs($rest - $h);
        $m = floor($rest * 60);
        $rest = ($rest - ($m / 60));
        $s = floor($rest * 3600);

        $description = '';
        if ($d > 0) {
            $description .= $d . ' ' . $dayText;
        }

        if ($h > 0) {
            $description .= ($description != '' ? ', ' : '') . $h . ' ' . $hourText;
        }

        if ($m > 0 || $h > 0) {
            $description .= ($description != '' ? ', ' : '') . $m . ' ' . $minText;
        }

        if ($s > 0 || $m > 0 || $h > 0) {
            $description .= ($description != '' ? ', ' : '') . $s . ' ' . $secText;
        }

        return $description;
    }

    /**
     * Undocumented function
     *
     * @param string $date
     * @param string $formatDate
     * @param string $formatWeek
     * @return string 
     */
    public static function getFirstDateWeek($date, $formatDate, $formatWeek = 'N')
    {
        if (!is_array($formatWeek, ['w', 'N'])) {
            throw new Exception('Format inválid, only "N" or "w"');
        }

        $init = [
            'N' => 1,
            'w' => 0,
        ];
        $dayOfWeek = intval(date($formatWeek, strtotime($date)));
        $days = $dayOfWeek - $init[$formatWeek];
        return date($formatDate, strtotime($date . ' -' . $days . ' day'));
    }

    /**
     * Undocumented function
     *
     * @param string $date
     * @param string $formatDate
     * @param string $formatWeek
     * @return string 
     */
    public static function getLastDateWeek($date, $formatDate, $formatWeek = 'N')
    {
        if (!is_array($formatWeek, ['w', 'N'])) {
            throw new Exception('Format inválid, only "N" or "w"');
        }

        $end = [
            'N' => 7,
            'w' => 6,
        ];
        $dayOfWeek = intval(date($formatWeek, strtotime($date)));
        $days = $end[$formatWeek] - $dayOfWeek;
        return date($formatDate, strtotime($date . ' +' . $days . ' day'));
    }
}

<?php

namespace AnexusPHP\Core\Tools;

class Base64
{
    private static $tables = [
        1 => [
            'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
            'w', 'x', 'y', 'z', '0', '1', '2', '3',
            'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
            '4', '5', '6', '7', '8', '9', '+', '/',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
            'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f'
        ],
    ];

    private static $modTable = [0, 2, 1];

    public static function setTable($key, array $table)
    {
        self::$tables[intval($key)] = $table;
    }

    private static function buildDecodingTable()
    {
        $decodingTable = [];
        for ($i = 0; $i < 64; $i++)
            $decodingTable[self::$table[$i]] = $i;

        return $decodingTable;
    }

    public static function decode($str)
    {
        self::buildDecodingTable();
        $inputLength = mb_strlen($str);

        if ($inputLength % 4 != 0)
            return;

        $outputLength = $inputLength / 4 * 3;
    if ($str[$inputLength - 1] == '=')
    	$outputLength--;
    if ($str[$inputLength - 2] == '=')
    	$outputLength--;

    $i = 0;
    $j = 0;
    while($i < $inputLength)
    {

    	$sextetA = $str[$i] == '=' ? 0 & $i++ : decoding_table[(unsigned char)dataIn[i++]];
    	$sextetB = $str[$i] == '=' ? 0 & i++ : decoding_table[(unsigned char)dataIn[i++]];
    	$sextetC = $str[$i] == '=' ? 0 & i++ : decoding_table[(unsigned char)dataIn[i++]];
    	$sextetD = $str[$i] == '=' ? 0 & i++ : decoding_table[(unsigned char)dataIn[i++]];

        uint32_t triple = (sextet_a << 3 * 6)
        + (sextet_b << 2 * 6)
        + (sextet_c << 1 * 6)
        + (sextet_d << 0 * 6);

        if (j < output_length) dataOut[j++] = (triple >> 2 * 8) & 0xFF;
        if (j < output_length) dataOut[j++] = (triple >> 1 * 8) & 0xFF;
        if (j < output_length) dataOut[j++] = (triple >> 0 * 8) & 0xFF;
    }
    }

    public static function encode($str)
    {
        $inputLength = mb_strlen($str);
        $j = 0;
        $i = 0;
        $out = '';
	    while($i < $inputLength)
        {
            $octetA = $i < $inputLength ? $str[$i++] : 0;
            $octetB = $i < $inputLength ? $str[$i++] : 0;
            $octetC = $i < $inputLength ? $str[$i++] : 0;

            $triple = ($octetA << 0x10) + ($octetB << 0x08) + $octetC;

            $out .= self::$tables[($triple >> 3 * 6) & 0x3F];
            $out .= self::$tables[($triple >> 2 * 6) & 0x3F];
            $out .= self::$tables[($triple >> 1 * 6) & 0x3F];
            $out .= self::$tables[($triple >> 0 * 6) & 0x3F];
        }

        for ($i = 0; $i < self::$modTable[$inputLength % 3]; $i++){
            $out[mb_strlen($out) - 1 - $i] = '=';
        }
    }
}

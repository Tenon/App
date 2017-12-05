<?php
namespace Tenon\Support;

class Output
{
    public static function stdout(array $out)
    {
        fprintf(STDOUT, self::format($out), "\n");
    }

    public static function stderr(array $err)
    {
        fprintf(STDERR, self::format($err), "\n");
    }

    protected static function format(array &$output)
    {
        $tmp = [];
        foreach ($output as $key => $value)
        {
            $tmp[] = "{$key} : {$value}";
        }
        return implode(" ; ", $tmp);
    }
}
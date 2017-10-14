<?php
namespace Tenon\Support;

class Output
{
    public static function stdout(string $out)
    {
        fprintf(STDOUT, $out, "\n");
    }

    public static function stderr(string $err)
    {
        fprintf(STDERR, $err, "\n");
    }

    public static function format(array &$output)
    {
        $tmp = [];
        foreach ($output as $key => $value)
        {
            $tmp[] = "{$key} : {$value}";
        }
        return implode(" ; ", $tmp);
    }

    public static function error(array $output)
    {
        self::stderr(self::format($output));
    }

    public static function debug(array $output)
    {
        self::stdout(self::format($output));
    }
}
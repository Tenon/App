<?php
namespace Tenon\Support;

class Arr
{
    public static function get(array $items, $key, $default = null)
    {
        //not exists
        if (empty($items) || is_null($key)) {
            return $default;
        }
        //no dot key
        if (strpos($key, '.') === false) {
            return $items[$key] ?? $default;
        }
        //key with dot
        foreach (explode('.', $key) as $segment) {
            if (isset($items[$segment]) && is_array($items[$segment])) {
                $items = $items[$segment];
            } else {
                return $default;
            }
        }
        return $items;
    }
}
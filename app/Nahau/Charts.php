<?php

namespace App\Nahau;

/** Tiny server-side SVG chart helpers for the admin dashboard (no JS chart library needed). */
class Charts
{
    /** Round the axis maximum up to a "nice" number so the grid labels read well. */
    public static function niceMax(float $max): int
    {
        if ($max <= 4) {
            return 4;
        }
        $pow = 10 ** (strlen((string) (int) ceil($max)) - 1);
        foreach ([1, 2, 2.5, 4, 5, 8, 10] as $m) {
            if ($m * $pow >= $max) {
                return (int) ($m * $pow);
            }
        }

        return (int) ceil($max);
    }

    /** @return array<int,array{0:float,1:float}> */
    public static function points(array $values, float $max, float $w = 800, float $h = 260, float $pt = 8, float $pb = 2): array
    {
        $n = max(1, count($values));
        $out = [];
        foreach (array_values($values) as $i => $v) {
            $x = $n > 1 ? $i * $w / ($n - 1) : $w / 2;
            $y = $h - $pb - ($max > 0 ? ($v / $max) * ($h - $pt - $pb) : 0);
            $out[] = [round($x, 1), round($y, 1)];
        }

        return $out;
    }

    /** Smooth (monotone-ish) line path through the points. */
    public static function line(array $pts): string
    {
        if (! $pts) {
            return '';
        }
        $d = 'M'.$pts[0][0].','.$pts[0][1];
        for ($i = 1, $c = count($pts); $i < $c; $i++) {
            $cx = round(($pts[$i - 1][0] + $pts[$i][0]) / 2, 1);
            $d .= ' C'.$cx.','.$pts[$i - 1][1].' '.$cx.','.$pts[$i][1].' '.$pts[$i][0].','.$pts[$i][1];
        }

        return $d;
    }

    public static function area(array $pts, float $w = 800, float $h = 260): string
    {
        return self::line($pts).' L'.$w.','.$h.' L0,'.$h.' Z';
    }
}

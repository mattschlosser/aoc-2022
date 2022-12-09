<?php


$file = file_get_contents(__DIR__ . "/input.txt");
$visited = [];
$head = [0, 0];
$tail = [0, 0];

function newTail($head, $tail) {
    [$hx, $hy] = $head;
    [$tx, $ty] = $tail;
    // for each step, we need to determine where to move the tail based on the head
    // same axis case - x
    if ($hx == $tx) {
        // move the tail closer by the number of spaces it is offet
        // the head and tail are offset by $diff
        $diff = $ty - $hy;
        if (abs($diff) == 2) {
            $ty += $diff > 0 ? -1 : 1;
        }
        return [$tx, $ty];
    }
    // same axis case - y
    if ($hy == $ty) {
        $diff = $tx - $hx;
        if (abs($diff) == 2) {
            $tx += $diff > 0 ? -1 : 1;
        }
        return [$tx, $ty];
    }
    // diagonal case
    $xdiff = $tx - $hx;
    $ydiff = $ty - $hy;
    // one diff will be 1 and one diff will be 2
    // however, we don't really care
    // we just need to move it cloaser by 1 in both directions
    if (abs($xdiff) == 2 || abs($ydiff) == 2) {
        $tx += $xdiff > 0 ? -1 : 1;
        $ty += $ydiff > 0 ? -1 : 1;
    }
    return [$tx, $ty];
}

enum Direction {
    case Right;
    case Left;
    case Up;
    case Down;
}

function toDirection(string $letter): Direction {
    return match ($letter) {
        "R" => Direction::Right,
        "U" => Direction::Up,
        "D" => Direction::Down,
        "L" => Direction::Left,
    };
}

$visited["0,0"] = true;

function update($knotPositions, $direction, $amount) {
    for ($i = 0; $i < $amount; $i++) {
        foreach ($knotPositions as $index => &$knotPosition) {
            if ($index == count($knotPositions) - 1) {
                continue;
            }
            [$hx, $hy] = $knotPositions[$index];
            [$tx, $ty] = $knotPositions[$index+1];
            if ($index == 0) {
                match ($direction) {
                    Direction::Right => $hx += 1,
                    Direction::Left => $hx -= 1,
                    Direction::Up => $hy += 1,
                    Direction::Down => $hy -= 1,
                };
            }
            [$tx, $ty] = newTail([$hx, $hy], [$tx, $ty]);
            if ($index == count($knotPositions)-2) {
                global $visited;
                $visited["$ty,$tx"] = true;
            }
            $knotPositions[$index] = [$hx, $hy];
            $knotPositions[$index+1] = [$tx, $ty];
        }
    }
    return $knotPositions;
}

// part 1
foreach (explode("\n", $file) as $line) {
    if (!$line) continue;
    [$letter, $amount] = explode(" ", $line);
    $direction = toDirection($letter);
    [$head, $tail] = update([$head, $tail], $direction, $amount);
}

echo count(array_keys($visited)) . PHP_EOL;

// part 2
$knots = 10;
$knotPositions = [];
for ($knot = 0; $knot < $knots; $knot++) {
    $knotPositions[] = [0, 0];
}

$visited = [];
$visited["0,0"] = true;


foreach (explode("\n", $file) as $line) {
    if (!$line) continue;
    [$letter, $amount] = explode(" ", $line);
    $direction = toDirection($letter);
    $knotPositions = update($knotPositions, $direction, $amount);
}


echo count(array_keys($visited)) . PHP_EOL;


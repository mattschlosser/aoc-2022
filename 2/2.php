<?php


$file = file_get_contents(__DIR__ . "/input.txt");
$results = [];
$result = 0;

enum Plays {
    case Rock;
    case Paper;
    Case Scissors;
}

enum Outcome {
    case Draw;
    case Win;
    case Lose;
}

function toOutcome($response) {
    return match ($response) {
        "X" => Outcome::Lose,
        "Y" => Outcome::Draw,
        "Z" => Outcome::Win
    };
}

function toPlay($expected) {
    return match ($expected) {
        "A" => Plays::Rock,
        "B" => Plays::Paper,
        "C" => Plays::Scissors,
        "X" => Plays::Rock,
        "Y" => Plays::Paper,
        "Z" => Plays::Scissors
    };
}

function score($expected, Plays $us) {
    $them = toPlay($expected);
    if ($them == $us) {
        return 3;
    }
    if ($them == Plays::Rock && $us == Plays::Scissors) {
        return 0;
    }
    if ($them == Plays::Scissors && $us == Plays::Paper) {
        return 0;
    }
    if ($them == Plays::Paper && $us == Plays::Rock) {
        return 0;
    }
    return 6;
}

function play(Plays $expected, Outcome $outcome) {
    if ($expected == Plays::Rock) {
        return match ($outcome) {
            Outcome::Draw => Plays::Rock,
            Outcome::Lose => Plays::Scissors,
            Outcome::Win => Plays::Paper
        };
    }
    if ($expected == Plays::Paper) {
        return match ($outcome) {
            Outcome::Draw => Plays::Paper,
            Outcome::Lose => Plays::Rock,
            Outcome::Win => Plays::Scissors
        };
    }
    if ($expected == Plays::Scissors) {
        return match ($outcome) {
            Outcome::Draw => Plays::Scissors,
            Outcome::Lose => Plays::Paper,
            Outcome::Win => Plays::Rock
        };
    }
    throw new Exception("Oops");
}

$sum = 0;

// part 1
foreach (explode("\n", $file) as $line) {
    if (!$line) continue;
    [$expected, $response] = explode(' ', $line);
    if ($expected == null) {
        continue;
    }
    $responseScore = match($response) {
        "X" => 1,
        "Y" => 2,
        "Z" => 3
    };
    $playSocre = score($expected, toPlay($response));
    $sum+= $responseScore + $playSocre;
}
echo $sum . PHP_EOL;


// part 2
$sum = 0;
foreach (explode("\n", $file) as $line) {
    if (!$line) continue;
    [$expected, $outcome] = explode(' ', $line);
    if ($expected == null) {
        continue;
    }
    $response = play(toPlay($expected), toOutcome($outcome));
    $responseScore = match($response) {
        Plays::Rock => 1,
        Plays::Paper => 2,
        Plays::Scissors => 3
    };
    $playSocre = score($expected, $response);
    $sum+= $responseScore + $playSocre;
}
echo $sum . PHP_EOL;
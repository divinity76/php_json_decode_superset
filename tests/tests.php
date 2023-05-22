<?php

declare(strict_types=1);
require_once(__DIR__ . '/../src/Divinity76/json_decode_superset/json_decode_superset.php');

use function Divinity76\json_decode_superset\json_decode_superset;

echo "require successful\n";
$tests = array(
    array(
        "json" => "{}",
        "associative" => true,
        "flags" => JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR,
        "expected" => array(),
    ),
    array(
        "json" => "[]",
        "associative" => true,
        "flags" => JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR,
        "expected" => array(),
    ),
    array(
        "json" => '{"a":1,"b":2,"c":3,"d":4,"e":5}',
        "associative" => true,
        "flags" => JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR,
        "expected" => array(
            "a" => 1,
            "b" => 2,
            "c" => 3,
            "d" => 4,
            "e" => 5,
        ),
    ),
    // now for some json-superset tests:
    array(
        // valid js, invalid json.
        "json" => '{a:1,b:2,c:3,d:4,e:5}',
        "associative" => true,
        "flags" => JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR,
        "expected" => array(
            "a" => 1,
            "b" => 2,
            "c" => 3,
            "d" => 4,
            "e" => 5,
        ),
    ),
);
$skip_slow = in_array("--skip-slow", $argv ?? []);
if (!$skip_slow) {
    // now for a very complex test derived from real-world data:
    $tests[] = array(
        "json" => file_get_contents(__DIR__ . "/complex_data1.js"),
        "associative" => true,
        "flags" => JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR,
        "expected" => json_decode(file_get_contents(__DIR__ . "/complex_data1_expected_result.json"), true, 512, JSON_THROW_ON_ERROR),
    );
}
foreach ($tests as $test) {
    $json = $test["json"];
    $associative = $test["associative"];
    $flags = $test["flags"];
    $expected = $test["expected"];
    $actual = json_decode_superset($json, $associative, 512, $flags);
    if ($actual !== $expected) {
        echo "test failed\n";
        echo "json: $json\n";
        echo "associative: $associative\n";
        echo "flags: $flags\n";
        echo "expected: " . json_encode($expected) . "\n";
        echo "actual: " . json_encode($actual) . "\n";
        exit(1);
    } else {
        $json_short = strlen($json) > 100 ? substr($json, 0, 100 - 3) . "..." : $json;
        echo "test passed: " . $json_short . "\n";
    }
}

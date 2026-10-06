<?php
$cases = glob(__DIR__ . '/cases/*.yl');
$fail = 0;
foreach ($cases as $c) {
    $expected = file_get_contents($c . '.expected');
    $actual = shell_exec('php ' . escapeshellarg(__DIR__ . '/../yl.php') . ' ' . escapeshellarg($c));
    if (trim($actual) !== trim($expected)) {
        echo "FAIL $c\n  ожидалось: " . trim($expected) . "\n  получено:  " . trim($actual) . "\n";
        $fail++;
    } else echo "OK   $c\n";
}
exit($fail ? 1 : 0);
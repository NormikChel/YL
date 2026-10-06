<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

$code = $_POST['code'] ?? '';
if ($code === '') { echo json_encode(['ok' => false, 'err' => 'Пустой код']); exit; }

$tmp = tempnam(sys_get_temp_dir(), 'yl_') . '.yl';
file_put_contents($tmp, $code);

$ylPath = __DIR__ . '/../yl.php';
$descriptor = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
$proc = proc_open(
    'php ' . escapeshellarg($ylPath) . ' --sandbox ' . escapeshellarg($tmp),
    $descriptor, $pipes
);
$out = stream_get_contents($pipes[1]);
$err = stream_get_contents($pipes[2]);
fclose($pipes[1]); fclose($pipes[2]);
$exit = proc_close($proc);
@unlink($tmp);

echo json_encode(['ok' => $exit === 0, 'out' => $out, 'err' => $err], JSON_UNESCAPED_UNICODE);
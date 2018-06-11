<?php
set_time_limit(0);   // set to maximum to allow for long tests.

$type = (!empty($_REQUEST['type'])) ? $_REQUEST['type'] : 'iperf';

switch ($type) {
  case "iperf" :
    $version = (!empty($_REQUEST['version'])) ? $_REQUEST['version'] : NULL;
    $target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
    $port    = (!empty($_REQUEST['port'])) ? $_REQUEST['port'] : NULL;
    $proto   = ($_REQUEST['proto']=='udp') ? ' -u ' : ' ';
    $params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
    $prog    = ($version == 2) ? 'iperf' : NULL;
    $args    = $proto . '-c ' . $target . ' -p ' . $port . ' ' . $params;
    $cmd     = escapeshellcmd($prog . $args);
    break;
  case "ping" :
    $prog    = 'ping';
    $target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : '8.8.8.8';
    $params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : '-c 4';
    $cmd     = escapeshellcmd($prog . ' ' . $params . ' ' . $target);
    break;
  case "traceroute" :
    $prog    = 'traceroute';
    $target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : '8.8.8.8';
    $params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
    $cmd     = escapeshellcmd($prog . ' ' . $params . ' ' . $target);
    break;
}

while (@ ob_end_flush()); flush(); // end all output buffers if any
ob_implicit_flush(true);           // turn on implicit flushing

$date = date("Y-m-d_H-i-s");
$timestamp = date("H:i:s d/m/Y");
$log = fopen("logs/$date.$type.log", "a+") or die("Unable to open file!");
$proc = popen($cmd, 'r');

echo "<pre>";

echo "COMMAND: $cmd\n";
echo "TIMESTAMP: $timestamp\n\n";

fwrite ($log, "COMMAND: $cmd\n");
fwrite ($log, "TIMESTAMP: $timestamp\n\n");

while (!feof($proc))
{
  $output = fread($proc, 4096);
  echo $output;
  fwrite($log, $output);
}

echo "</pre>";

echo "<h1>Logs:</h1>";
$path  = 'logs/';
$files = scandir($path);
$files = array_diff(scandir($path,1), array('.', '..'));
foreach ($files as $file) {
  echo "<p><a href='logs/$file'>$file</a></p>";
}

fclose($log);
fclose($proc);
?>

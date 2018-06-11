<?php
/* Increase PHP max execution time to allow for longer tests. */
set_time_limit(500);

$type = (!empty($_REQUEST['type'])) ? $_REQUEST['type'] : 'iperf';

switch ($type) {
  case "iperf" :
    $version = (!empty($_REQUEST['version'])) ? $_REQUEST['version'] : 2;
    $target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : 'ping.online.net';
    $port    = (!empty($_REQUEST['port'])) ? $_REQUEST['port'] : '5001';
    $proto   = ($_REQUEST['proto']=='udp') ? ' -u ' : ' ';
    $params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : '-i 1 -f -m';
    $prog    = ($version == 2) ? 'iperf' : 'iperf3';
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

while (@ ob_end_flush()); // end all output buffers if any
ob_implicit_flush(true);  // turn on implicit flushing

$date = date("Y-m-d");
$timestamp = date("H:i:s d/m/Y");
$log = fopen("/var/www/html/logs/$date.log", "a+") or die("Unable to open file!");
$proc = popen($cmd, 'r');

echo "COMMAND: $cmd\n";
echo "TIMESTAMP: $timestamp\n\n";

fwrite ($log, "\nCOMMAND: $cmd\n");
fwrite ($log, "TIMESTAMP: $timestamp\n\n");

while (!feof($proc))
{
  $output = fread($proc, 4096);
  echo $output;
  fwrite($log, $output);
}

fwrite ($log, "\n");

fclose($log);
fclose($proc);
?>

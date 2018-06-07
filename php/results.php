<?php
/* Increase PHP max execution time to allow for longer tests. */
set_time_limit(500);

/* https://stackoverflow.com/questions/1281140/run-process-with-realtime-output-in-php */
ob_end_flush();
ini_set("output_buffering", "0");
ob_implicit_flush(true);

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
    $prog = 'ping';
    $target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : '8.8.8.8';
    $params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : '-c 4';
    $cmd     = escapeshellcmd($prog . ' ' . $params . ' ' . $target);
    break;
  case "traceroute" :
    $prog = 'traceroute';
    $target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : '8.8.8.8';
    $params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
    $cmd     = escapeshellcmd($prog . ' ' . $params . ' ' . $target);
    break;
}

/* https://secure.php.net/manual/en/function.proc-open.php */
$descriptorspec = array(
  0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
  1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
  2 => array("pipe", "w")    // stderr is a pipe that the child will write to
);

$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());

echo "COMMAND: $cmd\n";
echo "TIMESTAMP: " . date("H:i:s d/m/Y") . "\n\n";

if (is_resource($process)) {
  fwrite($pipes[0]);
  fclose($pipes[0]);
  echo stream_get_contents($pipes[1]);
  echo stream_get_contents($pipes[2]);
  fclose($pipes[1]);
  fclose($pipes[2]);
  $return_value = proc_close($process);
  echo "\nRETURN VALUE: $return_value";
}
?>

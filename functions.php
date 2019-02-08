<?php
function disableOutputBuffering () {
  header('Cache-Control: no-cache');
  header('X-Accel-Buffering: no');

  ini_set('output_buffering', 'off');         // Turn off output buffering
  ini_set('zlib.output_compression', false);  // Turn off PHP output compression
  ini_set('implicit_flush', true);            // Implicitly flush the buffer(s)

  ob_implicit_flush(true);                    // belt and braces!
  while (@ ob_end_flush()); flush();          // end all output buffers if any

  // Clear, and turn off output buffering
  while (ob_get_level() > 0) {
    $level = ob_get_level();                  // Get the current level
    ob_end_clean();                           // End the buffering
    if (ob_get_level() == $level) break;      // If the current level has not changed, abort
  }

  // Disable apache output buffering/compression
  if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', '1');
    apache_setenv('dont-vary', '1');
  }
}

function checkdir ($dir) {
  if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
  }
}

function runCmd ($type, $cmd) {
  disableOutputBuffering();

  $date = date("Y-m-d_H-i-s");
  $timestamp = date("H:i:s d/m/Y");

  $logdir = $_SERVER['DOCUMENT_ROOT'] . '/logs';
  checkdir($logdir);
  $log = "$logdir/$date.$type.log";
  $log = fopen("$log", "w");
  $proc = popen("$cmd 2>&1", 'r');

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

  fclose($log);
  fclose($proc);
}

function getCmd ($prog, $args) {
  if (isset($_POST['cheat'])) {
    $cmd = escapeshellcmd("curl 'cheat.sh/'".$prog."?qT&style=bw");
    echo "<h1>$prog cheatsheet</h1>";
    echo '<pre>';
    passthru($cmd);
    echo '</pre>';
    getLogs();
    exit;
  } else if (isset($_POST['start'])) {
    $cmd = escapeshellcmd($prog . ' ' . $args);
  }
  return $cmd;
}

function getResults () {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // clear link var so that previous accessed log doesn't load after results
    if (isset($_GET['link'])) { unset($_GET['link']); }
    set_time_limit(0);   // set to maximum to allow for long tests.
    $type = (!empty($_REQUEST['type'])) ? $_REQUEST['type'] : NULL;

    switch ($type) {
      case "host" :
	$prog    = 'host';
	$target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
	$params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
	$args    = $params . ' ' . $target;
	$cmd     = getCmd($prog, $args);
	break;
      case "iperf" :
	$version = (!empty($_REQUEST['version'])) ? $_REQUEST['version'] : NULL;
	$target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
	$port    = (!empty($_REQUEST['port'])) ? $_REQUEST['port'] : NULL;
	$proto   = ($_REQUEST['proto']=='udp') ? ' -u ' : ' ';
	$params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
	$prog    = ($version == 2) ? 'iperf' : 'iperf3';
	$args    = $proto . '-c ' . $target . ' -p ' . $port . ' ' . $params;
	$cmd     = getCmd($prog, $args);
	break;
      case "nslookup" :
	$prog    = 'nslookup';
	$target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
	$params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
	$args    = $params . ' ' . $target;
	$cmd     = getCmd($prog, $args);
	break;
      case "ping" :
	$prog    = 'ping';
	$target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
	$params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
	$args    = $params . ' ' . $target;
	$cmd     = getCmd($prog, $args);
	break;
      case "traceroute" :
	$prog    = 'traceroute';
	$target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
	$params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
	$args    = $params . ' ' . $target;
	$cmd     = getCmd($prog, $args);
	break;
      case "whois" :
	$prog    = 'whois';
	$target  = (!empty($_REQUEST['target'])) ? $_REQUEST['target'] : NULL;
	$params  = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : NULL;
	$args    = $params . ' ' . $target;
	$cmd     = getCmd($prog, $args);
	break;
    }

    echo "<h1>$type OUTPUT</h1>";
    runCmd($type, $cmd);
  }
}

function getLogs () {
  $count = 0;
  $path  = 'logs/';
  $files = scandir($path);
  $files = array_diff(scandir($path,1), array('.', '..'));
  echo "<h1>LOGS</h1><table><tr>";
  foreach ($files as $file) {
    if ($count < 10) {
      echo "<tr>
		<td><a href='?link=$file'>$file</a>&nbsp;&nbsp;&nbsp;</td>
		<td><a href='logs/$file' download><i>Download</i></a></td>
	    </tr>";
    }
    $count++;
  }
  echo "</tr></table>";
  echo "<p><a href='logs/'>Show all logs...</a></p>";
}

function getLogContent() {
  if (isset($_GET['link'])) {
    $link = $_GET['link'];
    $contents = file_get_contents("./logs/$link");
    echo "<h1>LOG CONTENTS</h1>";
    echo "<pre>$contents</pre>";
  }
}
?>

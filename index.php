<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>SPEEDTEST UTILS</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
  </head>

  <body>
    <div class="row">
      <div class="column left">
	<h1>IPERF</h1>
	<form method="post">
	  <input name="type" type="hidden" value="iperf"/>
	  <table>
	    <tr>
	      <td>
		<label for="version" class="label">Version</label>
	      </td>
	      <td>
		<select id="version" name="version">
		  <option value="2" selected="selected">2</option>
		  <option value="3" >3</option>
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="target" class="label">Target</label>
	      </td>
	      <td>
		<input id="target" name="target" type="text" maxlength="255" value="ping.online.net"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="port" class="label">Port</label>
	      </td>
	      <td>
		<input id="port" name="port" type="text" maxlength="255" value="5001"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="type" class="label">Protocol</label>
	      </td>
	      <td>
		<select id="proto" name="proto">
		  <option value="tcp" selected="selected">TCP</option>
		  <option value="udp" >UDP</option>
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="params" class="label">Parameters</label>
	      </td>
	      <td>
		<input id="params" name="params" type="text" maxlength="255" value="-i 1 -f -m"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="timeout" class="label">Timeout</label>
	      </td>
	      <td>
		<input id="timeout" name="timeout" type="text" maxlength="3" value="15"/>
	      </td>
	    </tr>
	    <tr>
	      <td></td>
	      <td>
		<input type="submit" name="Start" value="Start" />
	      </td>
	    </tr>
	  </table>
	</form>

	<h1>PING</h1>
	<form method="post">
	  <input name="type" type="hidden" value="ping"/>
	  <table>
	    <tr>
	      <td>
		<label for="target" class="label">Target</label>
	      </td>
	      <td>
		<input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="params" class="label">Parameters</label>
	      </td>
	      <td>
		<input id="params" name="params" type="text" maxlength="255" value="-c 4"/>
	      </td>
	    </tr>
	    <td></td>
	    <td>
	      <input type="submit" name="Start" value="Start" />
	    </td>
	    </tr>
	  </table>
	</form>

	<h1>TRACEROUTE</h1>
	<form method="post"">
	  <input name="type" type="hidden" value="traceroute"/>
	  <table>
	    <tr>
	      <td>
		<label for="target" class="label">Target</label>
	      </td>
	      <td>
		<input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="params" class="label">Parameters</label>
	      </td>
	      <td>
		<input id="params" name="params" type="text" maxlength="255" value=""/>
	      </td>
	    </tr>
	    <tr>
	      <td></td>
	      <td>
		<input type="submit" name="Start" value="Start" />
	      </td>
	    </tr>
	  </table>
	</form>

	<div class="column right">
	  <h1>RESULT:</h1>
	  <?php
	  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    set_time_limit(0);   // set to maximum to allow for long tests.
	    while (@ ob_end_flush()); flush(); // end all output buffers if any
	    ini_set("output_buffering", "0");  // belt & braces!
	    ob_implicit_flush(true);           // turn on implicit flushing

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

	    fclose($log);
	    fclose($proc);
	  }
	  ?>
	</div>
      </div>

      <div class="row">
	<div class="column right">
	  <?php
	  echo "<h1 style='font-family: Arial, Helvetica, Sans-Serif;'>LOGS:</h1>";
	  $path  = 'logs/';
	  $files = scandir($path);
	  $files = array_diff(scandir($path,1), array('.', '..'));
	  for ($i=0; $i<10; $i++) {
	    echo "<p><a href='?link=$files[$i]'>$files[$i]</a></p>";
	  }
	  ?>
	  <p><a href="logs/">Show all logs...</a></p>
	</div>

	<div class="column left">
	  <h1>LOG VIEWER:</h1>
	  <?php
	  if (isset($_GET['link'])) {
	    $link = $_GET['link'];
	    $contents = file_get_contents("./logs/$link");
	    echo "<pre>$contents</pre>";
	  }
	  ?>
	</div>
      </div>
  </body>
</html>

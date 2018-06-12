<?php require 'functions.php' ?>
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
      </div>

      <div class="column right">
	<h1>RESULT</h1>
	<?php getResults() ?>
      </div>
    </div>

    <div class="row">
      <div class="column left">
	<h1>LOGS</h1>
	<?php getLogs()	?>
	<p><a href="logs/">Show all logs...</a></p>
      </div>

      <div class="column right">
	<h1>LOG VIEWER</h1>
	<?php getLogContent() ?>
      </div>
    </div>

  </body>
</html>

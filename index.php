<?php require 'functions.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>NET UTILS</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="icon" href="img/nodes.png" type="image/png">
  </head>
  <body>

    <div class="row">

      <div class="column left">
	<h1>IPERF</h1>
	<form method="post">
	  <input name="type" type="hidden" value="iperf"/>

	  <label for="version">Version:</label>
	  <select id="version" name="version">
	    <option value="2" selected="selected">2</option>
	    <option value="3" >3</option>
	  </select><br>

	  <label for="target">Target:</label>
	  <input id="target" name="target" type="text" maxlength="255" value="ping.online.net"/><br>

	  <label for="port">Port:</label>
	  <input id="port" name="port" type="text" maxlength="255" value="5001"/><br>

	  <label for="type">Protocol:</label>
	  <select id="proto" name="proto">
	    <option value="tcp" selected="selected">TCP</option>
	    <option value="udp">UDP</option>
	  </select><br>

	  <label for="params">Parameters:</label>
	  <input id="params" name="params" type="text" maxlength="255" value="-i 1 -f -m"/><br>

	  <label for="timeout">Timeout:</label>
	  <input id="timeout" name="timeout" type="text" maxlength="3" value="15"/><br>

	  <input type="submit" class="submit" name="Start" value="Start"/>
	</form>

	<h1>PING</h1>
	<form method="post">
	  <input name="type" type="hidden" value="ping"/>

	  <label for="target">Target:</label>
	  <input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/><br>

	  <label for="params">Parameters:</label>
	  <input id="params" name="params" type="text" maxlength="255" value="-c 4"/><br>

	  <input type="submit" class="submit" name="Start" value="Start"/>
	</form>

	<h1>TRACEROUTE</h1>
	<form method="post"">
	  <input name="type" type="hidden" value="traceroute"/>

	  <label for="target">Target:</label>
	  <input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/><br>

	  <label for="params">Parameters:</label>
	  <input id="params" name="params" type="text" maxlength="255" value=""/><br>

	  <input type="submit" class="submit" name="Start" value="Start"/>
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
	<table>
	  <tr>
	    <?php getLogs() ?>
	  </tr>
	</table>
	<p><a href="logs/">Show all logs...</a></p>
      </div>

      <div class="column right">
	<h1>LOG VIEWER</h1>
	<?php getLogContent() ?>
      </div>

    </div>

  </body>
</html>

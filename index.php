<?php require 'functions.php' ?>
<!DOCTYPE html>
<html>
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
	  <label title="Hostname or IP Address" for="target">Target:</label>
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
	  <input type="submit" name="start" value="Start"/>
	  <input type="submit" name="cheat" value="Cheatsheet"/>
	  <button onclick="window.open('https://iperf.fr/iperf-doc.php');" type="button">Manual</button>
	</form>

	<h1>NSLOOKUP</h1>
	<form method="post">
	  <input name="type" type="hidden" value="nslookup"/>
	  <label title="Hostname or IP Address" for="target">Target:</label>
	  <input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/><br>
	  <label for="params">Parameters:</label>
	  <input id="params" name="params" type="text" maxlength="255" value=""/><br>
	  <input type="submit" name="start" value="Start"/>
	  <input type="submit" name="cheat" value="Cheatsheet"/>
	  <button onclick="window.open('https://linux.die.net/man/1/nslookup');" type="button">Manual</button>
	</form>

	<h1>PING</h1>
	<form method="post">
	  <input name="type" type="hidden" value="ping"/>
	  <label title="Hostname or IP Address" for="target">Target:</label>
	  <input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/><br>
	  <label for="params">Parameters:</label>
	  <input id="params" name="params" type="text" maxlength="255" value="-c 4"/><br>
	  <input type="submit" name="start" value="Start"/>
	  <input type="submit" name="cheat" value="Cheatsheet"/>
	  <button onclick="window.open('https://linux.die.net/man/8/ping');" type="button">Manual</button>
	</form>

	<h1>TRACEROUTE</h1>
	<form method="post">
	  <input name="type" type="hidden" value="traceroute"/>
	  <label title="Hostname or IP Address" for="target">Target:</label>
	  <input id="target" name="target" type="text" maxlength="255" value="8.8.8.8"/><br>
	  <label for="params">Parameters:</label>
	  <input id="params" name="params" type="text" maxlength="255" value=""/><br>
	  <input type="submit" name="start" value="Start"/>
	  <input type="submit" name="cheat" value="Cheatsheet"/>
	  <button onclick="window.open('https://linux.die.net/man/8/traceroute');" type="button">Manual</button>
	</form>
      </div>

      <div class="column right">
	<?php getResults() ?>
	<?php getLogContent() ?>
	<?php getLogs() ?>
      </div>

    </div>
  </body>
</html>

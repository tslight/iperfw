<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Speedtest Utils</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!-- <script type="text/javascript" src="js/jquery-3.2.0.slim.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/form.js"></script> -->
  </head>

  <body>

    <div class="row">

      <div class="column left">

	<h1>Iperf</h1>
	<form id="formx" method="post" action="results.php" target="results">
	  <input id="typex" name="type" type="hidden" value="iperf"/>
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

	<h1>Ping</h1>
	<form id="formy" method="post" action="results.php" target="results">
	  <input id="typex" name="type" type="hidden" value="ping"/>
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

	<h1>Traceroute</h1>
	<form id="formy" method="post" action="results.php" target="results">
	  <input id="typex" name="type" type="hidden" value="traceroute"/>
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
	<h1>Results:</h1>
	<iframe id="results" name="results"></iframe>
      </div>

    </div>
  </body>
</html>

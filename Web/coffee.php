<?php
require("php_serial.class.php"); //import to read serial port
	$serial = new phpSerial;
	$verz="1.0";
	//set serial port
	$serial->deviceSet("/dev/ttyACM0");
	$serial->confBaudRate(9600);
	$serial->confParity("none"); 
	$serial->confCharacterLength(8);
	$serial->confStopBits(1); 
	$serial->confFlowControl("none");
	$serial->deviceOpen();
	error_reporting(E_ALL);
	
	/* Allow the script to hang around waiting for connections. */
	set_time_limit(0);

	/* Turn on implicit output flushing so we see what we're getting * as it comes in. */
	ob_implicit_flush();

	
	if (isset($_POST["rcmd"])) {//if the button pressed 
		$rcmd = $_POST["rcmd"];
		if($rcmd != null) {
       			if($rcmd == TurnOn){ 
				$serial->sendMessage(1);//send option to arduino
				
				$line = "";
				while (!$done) 
				{
					$read = $serial->readPort(); //reads return of arduino
					for ($i = 0; $i < strlen($read); $i++) 
					{
						if ($read[$i] == "\n") {
						$done = true;
						} 
						else {
							$line .= $read[$i];//concatenate
						}
					}
				}
				$msg = $line;
														
			}else if($rcmd == TurnOff){
				
				$serial->sendMessage(0);
				$line = 0;
  				
			}else if($rcmd == Submit ){
				$serial->sendMessage(2);	
				$time = $_POST["hour"] * 3600;
				$time+= $_POST["minu"]*60;
				$time+= $_POST["sec"];
				$serial->sendMessage($time); /* this is the number that it will write */
  				$line = "";
				while (!$done) 
				{
					$read = $serial->readPort();
					for ($i = 0; $i < strlen($read); $i++) 
					{
						if ($read[$i] == "\n") {
						$done = true;
						} 
						else {
							$line .= $read[$i];
						}
					}
				}
										
			}
			
  		}else{
  				die('Crap, something went wrong. The page just puked.');
		}
		$serial->deviceClose(); 
	}

	
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'> <!--import font-->
	<script src="time.js"></script>
	<title> Let's make a coffee</title>
</head>
<body>
	<div id ="header">
		<center>
			<h1>Smart Coffee Maker</h1>
			<b>Version <?php echo $verz; ?></b>
		</center>
	</div><!--end header-->
	<div id="page">
		<center>
		<div>
			<form method="post" action="<?php echo $PHP_SELF;?>">
		
				<input class="button" type="submit" value="TurnOn" name="rcmd">
			
				<input class="button" type="submit" value="TurnOff" name="rcmd">
			</form>
		</div>
		<div>
			<input class="button" type="submit" value="ProgramCoffee" name="rcmd" onclick="time()">	
		</div>
		<div id="time">
		</div>
		<div id="msg">
			<p><?php echo $msg; ?></p>
		</div>
		</center>
	</div> <!--end page-->
</body>
</html>

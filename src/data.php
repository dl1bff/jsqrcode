<?php

require 'Predis/Autoloader.php';
Predis\Autoloader::register();

if (isset ($_REQUEST['v']))
{
	$v = preg_replace("/[^0-9a-zA-Z,-]/", "", $_REQUEST['v']);
	
	$client = new Predis\Client();

	$title = $client->get("DESC-" . $v);

	if (isset($title))
	{
		echo "<h1>" . $title . "</h1>";

		$values = $client->get("VAL-" . $v);

		if (isset($values))
		{
			$k = preg_split("/[\s,]+/", $values);

			for ($i = 0; $i < count($k); ++$i)
			{
				$t = preg_split("/-/", $k[$i]);
				
				$desc = $client->get("DESC-" . $t[0]);
				$factor = $client->get("FACTOR-" . $t[0]);
				$format = $client->get("FORMAT-" . $t[0]);
				$value = $client->get($k[$i]);

				if (isset($desc) and isset($factor) and isset($format) and isset($value))
				{
					echo "<h2>" . $desc . "</h2>";
					echo "<p>" . sprintf($format, $value * $factor) . "</p>";
				}
			}
		}
	}
}


echo "<p>" . date("c") . "</p>";

?>

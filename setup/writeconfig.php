<?php

// fetch config
$config = $config2 = unserialize($_POST["config"]);

// merge existing configuration with new one
$config = array_merge($wakkaConfig, $config);

// remove config values for whatever reason
unset($config["allow_doublequote_html"]);

// set version to current version, yay!
$config["wakka_version"] = WAKKA_VERSION;

// convert config array into PHP code
$configCode = "<?php\n// wikka.config.php written at ".strftime("%c")."\n// do not change wikka_version manually!\n\n\$wakkaConfig = array(\n";
foreach ($config as $k => $v)
{
	$entries[] = "\t\"".$k."\" => \"".$v."\"";
}
$configCode .= implode(",\n", $entries).");\n?>";

// try to write configuration file
print("<strong>Writing configuration</strong><br />\n");
test("Writing configuration file <tt>".$wakkaConfigLocation."</tt>...", $fp = @fopen($wakkaConfigLocation, "w"), "", 0);

if ($fp)
{
	fwrite($fp, $configCode);
	// write
	fclose($fp);
	
	print("<p>That's all! You can now <a href=\"".$config["base_url"]."\">return to your Wikka site</a>. However, you are advised to remove write access to <tt>wikka.config.php</tt> again now that it's been written. Leaving the file writable can be a security risk!</p>");
}
else
{
	// complain
	print("<p><span class=\"failed\">WARNING:</span> The configuration file <tt>".$wakkaConfigLocation."</tt> could not be written. You will need to give your web server temporary write access to either your wakka directory, or a blank file called <tt>wikka.config.php</tt> (<tt>touch wikka.config.php ; chmod 666 wikka.config.php</tt>; don't forget to remove write access again later, ie <tt>chmod 644 wikka.config.php</tt>). If, for any reason, you can't do this, you'll have to copy the text below into a new file and save/upload it as <tt>wikka.config.php</tt> into the Wikka directory. Once you've done this, your Wikka site should work. If not, please visit <a href=\"http://wikka.jsnx.com/WikkaInstallation\">Wikka:WakkaInstallation</a>.</p>\n");
	?>
	<form action="<?php echo myLocation() ?>?installAction=writeconfig" method="POST">
	<input type="hidden" name="config" value="<?php echo htmlspecialchars(serialize($config2)) ?>" />
	<input type="submit" value="Try again" />
	</form>	
	<?php
	print("<div style=\"background-color: #EEEEEE; padding: 10px 10px;\">\n<xmp>".$configCode."</xmp>\n</div>\n");
}

?>
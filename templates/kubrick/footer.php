<!-- BEGIN PAGE FOOTER -->
<div id="footer">
<?php
	global $tstart;
	$wikka_patch_level = ($this->GetWikkaPatchLevel() == '0') ? '' : '-p'.$this->GetWikkaPatchLevel();
?>
</div>
<!-- END PAGE FOOTER -->
<!-- BEGIN SYSTEM INFO -->
<div id="smallprint">
<?php
echo $this->Link('http://validator.w3.org/check/referer', '', VALID_XHTML_LINK_DESC);
?> ::
<?php
echo $this->Link('http://jigsaw.w3.org/css-validator/check/referer', '', VALID_CSS_LINK_DESC);
?> ::
<?php
echo $this->Link('http://wikkawiki.org/', '', sprintf(POWERED_BY_WIKKA_LINK_DESC, 'WikkaWiki' .($this->IsAdmin() ? ' '.$this->GetWakkaVersion() . $wikka_patch_level : '')));
?>
</div>
<!-- END SYSTEM INFO -->

<p><br/></p>
<p><br/></p>
<div align="center">
<a href="http://sourceforge.net"><img src="http://sourceforge.net/sflogo.php?group_id=122342&amp;type=1" width="88" height="31" border="0" alt="sf.net" /></a>
<a href="http://www.phatcode.net/"><img src="images/phatcode-logo.gif" border="0" alt="phatcode" /></a>
</div>

<?php
if ($this->GetConfigValue('sql_debugging'))
{
	echo '<div class="smallprint"><strong>Query log:</strong><br />'."\n";
	foreach ($this->queryLog as $query)
	{
		echo $query['query'].' ('.$query['time'].')<br />'."\n";
	}
	echo '</div>'."\n";
}
//echo '<!--'.sprintf(PAGE_GENERATION_TIME, $this->microTimeDiff($tstart)).'-->'."\n";
?>

</div>
<!-- END PAGE WRAPPER -->
</body>
</html>

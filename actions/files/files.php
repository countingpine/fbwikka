<?php
if (isset($download) && $download <> '') {
    // link to download a file
    if ($text == '')
        $text = $download;

    //Although $output is passed to ReturnSafeHTML, it's better to sanitize $text here. At least it can avoid invalid XHTML.
    $text = $this->htmlspecialchars_ent($text);

    echo "<a href=\"".$this->href('files.xml',
                $this->GetPageTag(),
                'action=download&amp;file='.urlencode($download))."\">".$text."</a>";
}
?>

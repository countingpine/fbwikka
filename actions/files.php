<?php
/**
 * Display a form with file attachments to the current page.
 * 
 * This actions displays a form allowing users to download files uploaded to wiki pages. By default only 
 * wiki admins can upload and delete files. If the intranet mode option is enabled, any user with write access
 * to the current page can upload or remove file attachments. If the optional download parameter is set, a simple 
 * download link is displayed for the specified file.
 *
 * Usage: {{files [download="filename"] [text="download link text"]}}
 *
 * @package		Actions
 * @version		$Id$
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @filesource
 * 
 * @author Victor Manuel Varela (original code)
 * @author {@link http://wikkawiki.org/CryDust CryDust} (code overhaul, stylesheet)
 * 
 * @input 	string 	$download  	optional: prints a link to the file specified in the string
 * 			string 	$text		optional: a text for the link provided with the download parameter
 * @output	a form for file uploading/downloading and a table with an overview of attached files
 *
 * @uses	Wakka::HasAccess()
 * @uses	Wakka::IsAdmin()
 * @uses	Wakka::MiniHref()
 * @uses	Wakka::href()
 * @uses	Wakka::FormClose()
 * @uses	Wakka::GetPageTag()
 * @uses	Wakka::htmlspecialchars_ent()
 *
 * @todo security: check file type, not only extension
 * @todo use buttons instead of links for file deletion; #72 comment 7
 * @todo similarly replace download link with POST form button -> files handler 
 * 		 can then use only $_POST instead of $_GET
 * @todo replace intranet mode with fine-grained file ownership/ACL;
 * @todo integrate with edit handler for easy insertion of file links;
 * @todo maybe move some internal utilities to Wakka class?
 * @todo make datetime format configurable;
 * @todo add support for file versioning;
 * @todo add (AJAX-powered?) confirmation check on file deletion;
 * @todo integrate file table in page template, à la Wacko;
 */

$max_upload_size = $this->GetConfigValue( 'max_upload_size' );

if ($download <> '') {
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

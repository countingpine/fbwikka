<?php
/**
 * Handle download/deletion of a file. 
 *
 * Only files uploaded using the Wiki can be downloaded/deleted using this handler, 
 * and every user who has read access to the page to which the files are attached
 * can download them. For the deletion, only administrators can delete files.
 * Range: and Accept-Range: headers are supported, so advanced downloader tools can
 * be used to download heavy size files.
 * 
 * See also {@link files.php}, {@link Config::$upload_path}.
 *
 * @package		Handlers
 * @subpackage	Files
 * @version		$Id$
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @filesource
 * 
 * @uses		mkdir_r()
 * @uses		Wakka::GetPageTag()
 * @uses		Wakka::HasAccess()
 * @uses		Wakka::Href()
 * @uses		Wakka::IsAdmin()
 * @uses		Wakka::redirect()
 * @uses		Config::$upload_path
 */

// upload path
if ($this->config['upload_path'] == '') $this->config['upload_path'] = 'files';
$upload_path = $this->config['upload_path'].DIRECTORY_SEPARATOR.$this->GetPageTag(); #89
if (! is_dir($upload_path)) mkdir_r($upload_path);

$file = basename( urldecode( $_GET['file'] ) );

// do the action
switch ($_GET['action'])	#312 
{
    case 'download':
            // Disallow if file starts with '.'
            if ($this->HasAccess('read') && (!preg_match('/^\\./', $file))) {
                $path = $upload_path.DIRECTORY_SEPARATOR.$file;
                Header("Content-Length: ".filesize($path));
                Header("Content-Type: application/x-download");
                Header("Content-Disposition: attachment; filename=".$file);
                Header("Cache-control: must-revalidate");
                Header("Connection: close");
                @readfile($path);
                exit();
            }
            break;

    case 'delete':   
            if ($this->IsAdmin()) {
                @unlink($upload_path.DIRECTORY_SEPARATOR.$file);
            }
            print $this->redirect($this->Href());
            break;
}
?>

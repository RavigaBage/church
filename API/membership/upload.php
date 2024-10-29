<?php
class UploadData
{
    
    private $target_dir = "../images_folder/users/";
    public function _log($str)
    {   
        $log_str = date('d.m.Y') . ": {$str}\r\n";
        if (($fp = fopen('upload_log.txt', 'a+')) !== false) {
            fputs($fp, $log_str);
            fclose($fp);
        }
        
        if($str == 'success'){
            return json_encode(["status"=>"success","name"=>$_POST['resumableFilename']]);
        }else{
            return json_encode(["status"=>"error","name"=>$str]);
        }
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function createFileFromChunks($temp_dir, $fileName, $chunkSize, $totalSize, $total_files)
    {

        $total_files_on_server_size = 0;
        $temp_total = 0;
        foreach (scandir($temp_dir) as $file) {
            $temp_total = $total_files_on_server_size;
            $tempfilesize = filesize($temp_dir . '/' . $file);
            $total_files_on_server_size = $temp_total + $tempfilesize;
        }
        
        if ($total_files_on_server_size >= $totalSize) {
            if (($fp = fopen($this->target_dir . '/' . $fileName, 'w')) !== false) {
                for ($i = 1; $i <= $total_files; $i++) {
                    fwrite($fp, file_get_contents($temp_dir . '/' . $fileName . '.part' . $i));
                }
                fclose($fp);
            } else {
                $this->_log('cannot create the destination file');
                return false;
            }

        
            if (rename($temp_dir, $temp_dir . '_UNUSED')) {
                $this->rrmdir($temp_dir . '_UNUSED');
            } else {
                $this->rrmdir($temp_dir);
            }
            
        }

    }

    public function file_registry(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!(isset($_GET['resumableIdentifier']) && trim($_GET['resumableIdentifier']) != '')) {
                $_GET['resumableIdentifier'] = '';
            }
            $temp_dir = 'temp/' . $_GET['resumableIdentifier'];
            if (!(isset($_GET['resumableFilename']) && trim($_GET['resumableFilename']) != '')) {
                $_GET['resumableFilename'] = '';
            }
            if (!(isset($_GET['resumableChunkNumber']) && trim($_GET['resumableChunkNumber']) != '')) {
                $_GET['resumableChunkNumber'] = '';
            }
            $chunk_file = $temp_dir . '/' . $_GET['resumableFilename'] . '.part' . $_GET['resumableChunkNumber'];
            if (file_exists($chunk_file)) {
                header("HTTP/1.0 200 Ok");
            } else {
                header("HTTP/1.0 404 Not Found");
                return "ban";
            }
        }
        
        
        if (!empty($_FILES))
        if(!file_exists($this->target_dir.'/'.$_POST['resumableFilename'].'')){
            foreach ($_FILES as $file) {
                if ($file['error'] != 0) {
                    $this->_log('error ' . $file['error'] . ' in file ' . $_POST['resumableFilename']);
                    continue;
                }
        
                if (isset($_POST['resumableIdentifier']) && trim($_POST['resumableIdentifier']) != '') {
                    $temp_dir = 'temp/' . $_POST['resumableIdentifier'];
                }
                $dest_file = $temp_dir . '/' . $_POST['resumableFilename'] . '.part' . $_POST['resumableChunkNumber'];
        
                if (!is_dir($temp_dir)) {
                    mkdir($temp_dir, 0777, true);
                }
        
                if (!move_uploaded_file($file['tmp_name'], $dest_file)) {
                    $this->_log('Error saving (move_uploaded_file) chunk ' . $_POST['resumableChunkNumber'] . ' for file ' . $_POST['resumableFilename']);
                } else {
                    if (is_dir($this->target_dir)) {
                        $this->createFileFromChunks($temp_dir, $_POST['resumableFilename'], $_POST['resumableChunkSize'], $_POST['resumableTotalSize'], $_POST['resumableTotalChunks']);
                        if(file_exists($this->target_dir . '/' . $_POST['resumableFilename'])){
                            return($this->_log("success"));
                        }else{
                            return($this->_log("error occured could not upload file, try a different file"));
                        }
                    } else {
                        return($this->_log('target directory cannot be found' . $this->target_dir));
                    }
                }
            }
        }else{
            return($this->_log("success"));
        }
        }
}

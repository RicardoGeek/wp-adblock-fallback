<?php
  class FileUploadHelper {
    
    public function handleImageUpload($filename, $savePath) {
      try {
        if ( !isset($_FILES[$filename]['error']) || is_array($_FILES[$filename]['error']) ) {
          throw new RuntimeException('Invalid parameters.');
        }
        
        switch ($_FILES[$filename]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        if ($_FILES[$filename]['size'] > 1000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES[$filename]['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            throw new RuntimeException('Invalid file format.');
        }
        
        $final_name = sha1_file($_FILES[$filename]['tmp_name']);
        if (!move_uploaded_file(
            $_FILES[$filename]['tmp_name'],
            sprintf('%s/%s.%s',
                $savePath,
                $final_name,
                $ext
            )
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
        return $final_name.'.'.$ext;
      } catch (RuntimeException $e) {
        return $e->getMessage();
      }
    }
    
  }
?>
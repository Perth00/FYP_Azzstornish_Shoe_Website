<?php 
class FileUploader {
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function uploadProductPicAdmin() {
        if (isset($this->file['file']) && $this->file['file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $this->file['file']['tmp_name'];
            $fileName = $this->file['file']['name'];
            $fileSize = $this->file['file']['size'];
            $fileType = $this->file['file']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            $allowedfileExtensions = array(
                'jpg', 'jpeg', 'gif', 'png', 'bmp', 'webp', 'tiff', 'tif', 'ico', 'svg', 'psd', 'hdr', 'jp2', 'pcx', 'ppm',
                'pgm', 'pbm', 'xcf', 'dds', 'wmf', 'emf', 'pgf', 'svgz', 'iff', 'raw', 'cr2', 'nef', 'orf', 'arw', 'rw2', 'dng'
            );
                
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir ='image/';
                $destPath = $uploadFileDir . $newFileName; //for storing in the database
                move_uploaded_file($fileTmpPath, $destPath);
            } else {
                $newFileName = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            $newFileName = 'Error uploading file. Please check if a file was selected.';
        }
        return $newFileName;
    }


    public function uploadProductPicUser() {
        if (isset($this->file['file']) && $this->file['file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $this->file['file']['tmp_name'];
            $fileName = $this->file['file']['name'];
            $fileSize = $this->file['file']['size'];
            $fileType = $this->file['file']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            $allowedfileExtensions = array(
                'jpg', 'jpeg', 'gif', 'png', 'bmp', 'webp', 'tiff', 'tif', 'ico', 'svg', 'psd', 'hdr', 'jp2', 'pcx', 'ppm',
                'pgm', 'pbm', 'xcf', 'dds', 'wmf', 'emf', 'pgf', 'svgz', 'iff', 'raw', 'cr2', 'nef', 'orf', 'arw', 'rw2', 'dng'
            );
                
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir ='image/user/';
                $destPath = $uploadFileDir . $newFileName; //for storing in the database
                move_uploaded_file($fileTmpPath, $destPath);
            } else {
                $newFileName = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            $newFileName = 'Error uploading file. Please check if a file was selected.';
        }
        return $newFileName;
    }

    public function uploadPicUser() {
        if (isset($this->file['file']) && $this->file['file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $this->file['file']['tmp_name'];
            $fileName = $this->file['file']['name'];
            $fileSize = $this->file['file']['size'];
            $fileType = $this->file['file']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            $allowedfileExtensions = array(
                'jpg', 'jpeg', 'gif', 'png', 'bmp', 'webp', 'tiff', 'tif', 'ico', 'svg', 'psd', 'hdr', 'jp2', 'pcx', 'ppm',
                'pgm', 'pbm', 'xcf', 'dds', 'wmf', 'emf', 'pgf', 'svgz', 'iff', 'raw', 'cr2', 'nef', 'orf', 'arw', 'rw2', 'dng'
            );
                
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir ='../Admin/image/user/';
                $destPath = $uploadFileDir . $newFileName; //for storing in the database
                move_uploaded_file($fileTmpPath, $destPath);
            } else {
                $newFileName = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            $newFileName = 'Error uploading file. Please check if a file was selected.';
        }
        return $newFileName;
    }


    
}
?>

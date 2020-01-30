<?php

class Image {

    const IMAGE_ORIGINAL = 'ORIGINAL';
    const IMAGE_LARGE = 'LARGE';
    const IMAGE_MEDIUM = 'MEDIUM';
    const IMAGE_SMALL = 'SMALL';
    const IMAGE_THUMB = 'THUMB';
    const IMAGE_ROUNDED = 'ROUNDED';

    public static function getMime($name, $location = null) {
		$mimes = &get_mimes();
        $exp = explode('.', $name);
        $extension = strtolower(end($exp));
        
        if (isset($mimes[$extension])) {
            $mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
        } else if (!empty($location)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $location);
            finfo_close($finfo);
        } else {
            $mime = 'application/octet-stream';
        }
        return $mime;
    }

    public static function getLocation($id, $size, $name, $folder) {
        $CI = & get_instance();
        $config = $CI->config->item('utils');

        return $config['full_upload_dir'] . $folder . '/' . self::getFileName($id, $size, $name);
    }

    public static function getFileSize($id, $size, $name, $folder) {
        $location = self::getLocation($id, $size, $name, $folder);
        return file_exists($location) ? filesize($location) : 0;
    }

    public static function getProperty($id, $size, $name, $folder) {
        $location = self::getLocation($id, $size, $name, $folder);
        return file_exists($location) ? getimagesize($location) : FALSE;
    }

    public static function getImage($id, $name, $folder) {
        if (empty($name)) {
            return NULL;
        }

        $images = array();
        foreach (array(self::IMAGE_ORIGINAL, self::IMAGE_LARGE, self::IMAGE_MEDIUM, self::IMAGE_SMALL, self::IMAGE_THUMB) as $size) {
            $filesize = self::getFileSize($id, $size, $name, $folder);
            if ($filesize > 0) {
                $location = self::getLocation($id, $size, $name, $folder);
                list($width, $height, $mime) = self::getProperty($id, $size, $name, $folder);
                $sizeName = camelize(strtolower($size));
                $images[$sizeName] = array(
                    'name' => self::getFileName($id, $size, $name),
                    'mime' => self::getMime($name, $location),
                    'size' => $filesize,
                    'width' => $width,
                    'height' => $height,
                    'type' => $sizeName,
                    'link' => self::createLink($id, $size, $name, $folder)
                );
            }
        }

        return (!empty($images)) ? $images : NULL;
    }

    public static function generateLink($id, $name, $folder) {

        $images = array();
        foreach (array(self::IMAGE_ORIGINAL, self::IMAGE_LARGE, self::IMAGE_MEDIUM, self::IMAGE_SMALL, self::IMAGE_THUMB) as $size) {
            $images[camelize(strtolower($size))] = self::createLink($id, $size, $name, $folder);
        }

        return $images;
    }

    public static function setFileName($name) {
        return str_replace('_', '-', underscore($name));
    }

    public static function getFileName($id, $size, $name) {
        //$name = self::setFileName($name);
        //return strtolower($size) . '-' . md5($id . $size) . md5($id . $name) . '-' . $name;
        // die($name);
        return strtolower($size) . '-' . md5($id) . '-' . $name;
    }

    public static function getName($link) {
        $part = explode('-', $link);
        unset($part[0], $part[1]);        
        return implode('-', $part);
    }

    public static function createLink($id, $size, $name, $folder) {
        $CI = & get_instance();
        $config = $CI->config->item('utils');
        $image = $config['upload_dir'] . $folder . '/' . self::getFileName($id, $size, $name);
        return (file_exists($image)) ? base_url() . $image : null;
    }

    public static function createFile($id,$size,$name,$blob){
        $namaFile = "assets/uploads/posts/photos/" . self::getFileName($id, $size, $name);
        file_put_contents($namaFile, $blob);
        return $namaFile;
    }

    /**
     * 
     * @param string|integer $id (Primary Key)
     * @param string $name
     * @param string $folder (posts/images)r
     * @return boolean
     */
    public static function upload($field, $id, $name='', $folder, $config = array()) {
        $CI = & get_instance();
        $ciConfig = $CI->config->item('utils');
        $config['upload_path'] = $path = $ciConfig['full_upload_dir'] . $folder . '/';
        $config['allowed_types'] = '*';
        $arr_name=explode(' ',$name);
        $name = implode('_',$arr_name);
        $config['file_name'] = $fileName = self::getFileName($id, self::IMAGE_ORIGINAL, $name);
        $config['remove_spaces']=TRUE;
        $CI->load->library('upload');
        $CI->load->library('image_lib');
        $upload = new CI_Upload($config);
        
        
        $upload->overwrite = true;
        if (!$upload->do_upload($field)) {
            return $upload->display_errors('', '');
        } else {
            $imageConfig = array('source_image' => $path . $fileName);
            if (!$name) {
                $imageConfig['source_image'] .= $upload->file_ext;
            }
            

            list($width, $height) = self::getProperty($id, self::IMAGE_ORIGINAL, $name, $folder);

            foreach (array(self::IMAGE_LARGE, self::IMAGE_MEDIUM, self::IMAGE_SMALL, self::IMAGE_THUMB) as $size) {
                $imageConfig['new_image'] = $path . self::getFileName($id, $size, $name);
                if (!$name) {
                    $imageConfig['new_image'] .= $upload->file_ext;
                }

                list($imageConfig['width'], $imageConfig['height']) = explode('x', $ciConfig['image'][strtolower($size)]);
                if ($width > $height) {
                    unset($imageConfig['width']);
                } else {
                    unset($imageConfig['height']);
                }
                var_dump($imageConfig);

                $image = new CI_Image_lib();
                $image->initialize($imageConfig);
                $image->resize();
                $image->clear();
            }
            
            $imagick = new Imagick();
            $file = $path . self::getFileName($id, self::IMAGE_ORIGINAL, $name);

            if (!$name) {
                $file .= $upload->file_ext;
            }

            $imagick->readImage($file);
            
            $iWidth = $imagick->getImageWidth();
            $iHeight = $imagick->getImageHeight();
            
            if($iWidth != $iHeight) {
                $x = $y = 0;
                if($iWidth > $iHeight) {
                    $x = round(($iWidth-$iHeight)/2);
                    $iWidth = $iHeight;
                }
                else {
                    $y = round(($iHeight-$iWidth)/2);
                    $iHeight = $iWidth;
                }

                $imagick->cropImage($iWidth, $iHeight, $x, $y);
            }
            
            $size = 150;
            if(!empty($size)) {
                $iWidth = $iHeight = $size;
                $imagick->scaleImage($iWidth, $iHeight);
            }
            
            $file = str_replace('medium', 'rounded', $file);
            file_put_contents($file, $imagick);

            return TRUE;
        }
    }

    public static function copy($link, $id, $name, $folder, $config = array()) {
        $CI = & get_instance();
        $ciConfig = $CI->config->item('utils');
        $path = $ciConfig['upload_dir'] . $folder . '/';
        $imageConfig = array('source_image' => $link);
        list($width, $height) = file_exists($link) ? getimagesize($link) : FALSE;

        foreach (array(self::IMAGE_ORIGINAL, self::IMAGE_LARGE, self::IMAGE_MEDIUM, self::IMAGE_SMALL, self::IMAGE_THUMB) as $size) {
            $imageConfig['new_image'] = $path . self::getFileName($id, $size, $name);
            list($imageConfig['width'], $imageConfig['height']) = explode('x', $ciConfig['image'][strtolower($size)]);
            if (empty($imageConfig['width']) && empty($imageConfig['height'])) {
                $imageConfig['width'] = $width;
                $imageConfig['height'] = $height;
            }
            if ($width > $height) {
                unset($imageConfig['width']);
            } else {
                unset($imageConfig['height']);
            }
            $image = new CI_Image_lib();
            $image->initialize($imageConfig);
            $image->resize();
            $image->clear();
        }
        return TRUE;
    }

    public static function remove($id, $name, $folder) {
        foreach (array(self::IMAGE_ORIGINAL, self::IMAGE_LARGE, self::IMAGE_MEDIUM, self::IMAGE_SMALL, self::IMAGE_THUMB) as $size) {
            $image = self::getLocation($id, $size, $name, $folder);
            if (file_exists($image)) {
                unlink($image);
            }
        }
    }

}

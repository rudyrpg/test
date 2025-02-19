<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_Upload extends CI_Upload
{
    public $multi = 'all';
    public $multi_errors = array();
    public $finished = FALSE;
    public $tempString;
    public $uploadedFiles = array();

    function __construct($config = array())
    {
        parent::__construct($config);
        if (array_key_exists('multi', $config)) {
            $this->set_multi($config['multi']);
        }
    }

    public function file_upload($field = 'userfile')
    {

        if (!isset($_FILES[$field])) {
            return false;
        }

        if (!is_array($_FILES[$field]['name'])) {
            return parent::file_upload($field);
        } elseif (sizeof($_FILES[$field]['name']) == 1) {
            $files = $_FILES[$field];
            $_FILES[$field]['name'] = $files['name'][0];
            $_FILES[$field]['type'] = $files['type'][0];
            $_FILES[$field]['tmp_name'] = $files['tmp_name'][0];
            $_FILES[$field]['error'] = $files['error'][0];
            $_FILES[$field]['size'] = $files['size'][0];
            return $this->file_upload($field);
        }
        // else do the magic
        else {
            $files = $_FILES[$field];
            foreach ($files['name'] as $key => $value) {
                $_FILES[$field]['name'] = $files['name'][$key];
                $_FILES[$field]['type'] = $files['type'][$key];
                $_FILES[$field]['tmp_name'] = $files['tmp_name'][$key];
                $_FILES[$field]['error'] = $files['error'][$key];
                $_FILES[$field]['size'] = $files['size'][$key];
                if ($this->file_upload($field)) {
                    $this->uploadedFiles[] = $this->data();
                } else {
                    $this->tempString = 'File: ' . $_FILES[$field]['name'] . ' - Error: ';
                    $this->multi_errors[] = $this->display_errors('', '');
                }
                switch ($this->multi) {
                    case 'all':
                        if (sizeof($this->multi_errors) > 0 && sizeof($this->uploadedFiles > 0)) {
                            foreach ($this->uploadedFiles as $dataFile) {
                                if (file_exists($dataFile['full_path'])) unlink($dataFile['full_path']);
                            }
                            break 2;
                        }
                        break;
                    case 'halt':
                        if (sizeof($this->multi_errors) > 0) break 2;
                        break;
                    default:
                        break;
                }
            }
            if (sizeof($this->multi_errors) > 0 && $this->multi == 'all') {
                return FALSE;
            }
            $this->finished = TRUE;
            return TRUE;
        }
    }

    public function data($index = NULL)
    {
        if ($this->finished === TRUE) {
            return $this->uploadedFiles;
        }
        $data = array(
            'file_name'        => $this->file_name,
            'file_type'        => $this->file_type,
            'file_path'        => $this->upload_path,
            'full_path'        => $this->upload_path . $this->file_name,
            'raw_name'        => str_replace($this->file_ext, '', $this->file_name),
            'orig_name'        => $this->orig_name,
            'client_name'        => $this->client_name,
            'file_ext'        => $this->file_ext,
            'file_size'        => $this->file_size,
            'is_image'        => $this->is_image(),
            'image_width'        => $this->image_width,
            'image_height'        => $this->image_height,
            'image_type'        => $this->image_type,
            'image_size_str'    => $this->image_size_str,
        );

        if (!empty($index)) {
            return isset($data[$index]) ? $data[$index] : NULL;
        }

        return $data;
    }

    public function display_errors($open = '<p>', $close = '</p>')
    {
        if ($this->finished === TRUE) {
            return $this->multi_errors;
        }
        $append = $this->tempString;
        $this->tempString = '';

        return (count($this->error_msg) > 0) ? $open . $append . implode($close . $open, $this->error_msg) . $close : '';
    }

    public function set_multi($course)
    {
        $options = array('all', 'halt', 'ignore');
        if (in_array($course, $options)) {
            $this->multi = $course;
        }
        return $this;
    }
}

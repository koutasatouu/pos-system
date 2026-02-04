<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    /**
     * PHP 8.1 Compatibility Fix
     * Overrides the error_array method to ensure we don't pass NULL to trim
     */
    public function set_rules($field, $label = '', $rules = array(), $errors = array())
    {
        // If the field is missing from $_POST, set it to empty string to satisfy PHP 8.1
        if ($this->CI->input->method() === 'post' && $this->CI->input->post($field) === NULL) {
            $_POST[$field] = '';
        }

        return parent::set_rules($field, $label, $rules, $errors);
    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * class Adodbloader
 * @author Daniel Hutauruk
 */
Class Adodbloader{
    function Adodbloader(){
        if ( !class_exists('ADONewConnection') )
            require_once(APPPATH.'third_party/adodb/adodb.inc'.EXT);
        
        $obj =& get_instance();
        $this->_init_adodb_library($obj); 
    } 

    function _init_adodb_library(&$ci) {
        $db_var = false; 
        $debug = false; 

        if (!isset($dsn)) {
            // fallback to using the CI database file 
            include(APPPATH.'config/database'.EXT); 
            
            $group = 'default'; 
            $dsn = 'postgres://'.$db[$group]['username'] 
                   .':'.$db[$group]['password'].'@'.$db[$group]['hostname']
                   .'/'.$db[$group]['database']; 
        } 

        // $ci is by reference, refers back to global instance
        $ci->adodb =& ADONewConnection($dsn);

        if ($db_var) {
            // also set the normal CI db variable
            $ci->db =& $ci->adodb; 
        } 

        if ($debug) {
            $ci->adodb->debug = true;
        }
    }
}
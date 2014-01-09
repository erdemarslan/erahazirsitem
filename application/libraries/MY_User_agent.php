<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_user_agent
 * 
 * This extends Browscap, not the native CI user
 * agent library.  This offers more flexibility
 * and reliability over the native CI library. It
 * also uses the same information as the native
 * PHP get_browser() function, which is often not
 * enabled.
 * 
 * I have commented out the namespace declaration in
 * line 3 of the parent class as it didn't work on
 * my server (using PHP 5.3.8).
 *
 * @link http://php.net/manual/en/function.get-browser.php
 * @link https://github.com/garetjax/phpbrowscap
 * @author Simon Emms <simon@simonemms.com>
 */

/* Load Browscap */
require_once(FCPATH.APPPATH.'/third_party/Browscap.php');

class MY_User_agent extends Browscap {
    
    
    /* Browscap data */
    protected $_arrBrowscap;
    
    /* Where we map over the platforms */
    protected $_arrPlatformMap;
    
    /* Where we map over the browsers */
    protected $_arrBrowserMap;
    
    /* Where we map over the mobiles */
    protected $_arrMobileMap;
    
    /* Where we map over the robots */
    protected $_arrRobotMap;
    
    protected $_arrCharsets = array();
    
    protected $_arrLanguages = array();
    
    
    
    
    
    public function __construct() {
        /* Build the cache directory */
        $cache = $this->_cache_dir('browscap');
        
        /* Instantiate the parent class */
        parent::__construct($cache);
        
        /* Get the browscap info as array */
        $this->_arrBrowscap = $this->getBrowser(null, true);
        
        /* Load config values */
        $this->_load_agent_file();
    }
    
    
    
    
    
    
    
    /**
     * Call
     * 
     * Any function that shares a name with a value
     * in the browscap array returns the value.
     * 
     * Returns false if not present
     * 
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        $arrBrowser = $this->getBrowser();
        
        $name = strtolower($name);
        
        $arrBrowser = array_change_key_case($arrBrowser, CASE_LOWER);
        
        if(array_key_exists($name, $arrBrowser)) {
            return $arrBrowser[$name];
        }
        
        /* Not found */
        return false;
    }
    
    
    
    
    
    
    
    /**
    * Cache Dir
    *
    * Return the cache directory. If you specify a
    * sub directory, it returns where that is in
    * the cache.
    *
    * THIS REALLY SHOULD BE NATIVE TO CI!!!
    *
    * @param string $subdir
    * @return string
    */
    protected function _cache_dir($subdir = null) {
        $objCI = &get_instance();
        $cache = $objCI->config->item('cache_path');

        if(empty($cache)) { $cache = FCPATH.APPPATH.'cache/'; }
        else { $cache = FCPATH.APPPATH.$cache; }

        if(!is_writable($cache)) {
            show_error("Cache directory <i>{$cache}</i> must be writable");
        } else {
            if(!is_null($subdir)) {
                $arrDir = preg_split('/\//', $subdir);
                if(count($arrDir) > 0) {
                    foreach($arrDir as $dir) {
                        if(!empty($dir)) {
                            $cache .= '/'.$dir;
                            $cache = $this->_remove_slash($cache);
                            /* If directory doesn't exist in cache, create it */
                            if(!is_dir($cache)) {
                                mkdir($cache, 0777, true);
                                chmod($cache, 0777);
                            }
                        }
                    }
                }
            }
            /* Add trailing slash for good measure */
            $cache .= '/';
            return $this->_remove_slash($cache);
        }
    }
    
    
    
    
    
    
    /**
     * Load Agent File
     * 
     * Loads the config file.  Unlike the CI native
     * version, we don't need to bother naming everything.
     * However, if we want to use a more common name (eg,
     * MSIE instead of IE, which is what Browscap returns) we
     * can set this in the config file
     * 
     * @return boolean
     */
    protected function _load_agent_file() {
        if(defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php')) {
            include(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php');
        } elseif (is_file(APPPATH.'config/user_agents.php')) {
            include(APPPATH.'config/user_agents.php');
        } else {
            return FALSE;
        }
        
        $return = false;
        
        if(isset($platform)) {
            $return = true;
            
            if(is_array($platform) && count($platform) > 0) {
                /* Lowercase they keys */
                $platform = array_change_key_case($platform, CASE_LOWER);
                $this->_arrPlatformMap = $platform;
            }
        }
        
        if(isset($browser)) {
            $return = true;
            
            if(is_array($browser) && count($browser) > 0) {
                /* Lowercase they keys */
                $browser = array_change_key_case($browser, CASE_LOWER);
                $this->_arrBrowserMap = $browser;
            }
        }
        
        if(isset($mobiles)) {
            $return = true;
            
            if(is_array($mobiles) && count($mobiles) > 0) {
                /* Lowercase they keys */
                $mobiles = array_change_key_case($mobiles, CASE_LOWER);
                $this->_arrMobileMap = $mobiles;
            }
        }
        
        if(isset($robots)) {
            $return = true;
            
            if(is_array($robots) && count($robots) > 0) {
                /* Lowercase they keys */
                $robots = array_change_key_case($robots, CASE_LOWER);
                $this->_arrRobotMap = $robots;
            }
        }
        
        return $return;
    }
    
    
    
    
    
    
    /**
    * Remove Slash
    *
    * Removes excess slashes from
    * a string
    *
    * @param string $string
    * @return string
    */
    protected function _remove_slash($string) {
        /* Check for an http(s)/ftp at the start */
        if(preg_match('/^(http(s)?|ftp|rtmp)\:\/\//', $string, $match)) {
            /* There's a legitimate double slash - keep it */
            $return = isset($match[0]) ? $match[0] : '';
            $arrString = preg_split('/^(http(s)?|ftp|rtmp)\:\/\//', $string);
            if(count($arrString) > 0) {
                foreach($arrString as $string) {
                    $return .= $this->_remove_slash($string);
                }
            }
            return $return;
        } else {
            /* No legitimate double slashes - get rid of them all */
            return preg_replace('/(\w)?(\/\/+)/', '\\1/', $string);
        }
    }
    
    
    
    
    
    
    /**
     * Set Charsets
     * 
     * Sets the accepted character sets 
     */
    protected function _set_charsets() {
        if ((count($this->_arrCharsets) == 0) AND isset($_SERVER['HTTP_ACCEPT_CHARSET']) AND $_SERVER['HTTP_ACCEPT_CHARSET'] != '') {
            $charsets = preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));

            $this->_arrCharsets = explode(',', $charsets);
        }

        if (count($this->_arrCharsets) == 0) {
            $this->_arrCharsets = array('Undefined');
        }
    }
    
    
    
    
    
    
    
    
    protected function _set_languages() {
        if ((count($this->_arrLanguages) == 0) AND isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) AND $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '') {
            $languages = preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

            $this->_arrLanguages = explode(',', $languages);
        }

        if (count($this->_arrLanguages) == 0) {
            $this->_arrLanguages = array('Undefined');
        }
    }
    
    
    
    
    
    
    
    /**
     * Accpet Charset
     * 
     * Test for a particular character set
     * 
     * @param string $charset
     * @return bool
     */
    public function accept_charset($charset = 'utf-8') {
        return (in_array(strtolower($charset), $this->charsets(), TRUE));
    }
    
    
    
    
    
    
    
    
    
    /**
     * Accept lang
     * 
     * Tests for a particular language
     * 
     * @param string $lang
     * @return bool
     */
    public function accept_lang($lang = 'en') {
        return (in_array(strtolower($lang), $this->languages(), TRUE));
    }
    
    
    
    
    
    
    
    
    /**
     * Agent String
     * 
     * Returns the agent string
     * 
     * @return string
     */
    public function agent_string() { return $this->browser_name(); }
    
    
    
    
    
    
    
    
    
    /**
     * Charsets
     * 
     * Get the character sets we can accept
     * 
     * @return array
     */
    public function charsets() {
        if(count($this->_arrCharsets) == 0) {
            $this->_set_charsets();
        }

        return $this->_arrCharsets;
    }
    
    
    
    
    
    
    
    
    /**
     * Get Browser
     * 
     * Returns the information about the browser
     * 
     * @param string $user_agent
     * @param bool $return_array
     * @return array/object
     */
    public function getBrowser($user_agent = null, $return_array = true) {
        if(is_null($this->_arrBrowscap) || !is_null($user_agent) || $return_array === false) {
            /* First time query, or using same user agent and returning as array */
            return parent::getBrowser($user_agent, $return_array);
        } else {
            /* Subsequent call, using default agent and is array */
            return $this->_arrBrowscap;
        }
    }
    
    
    
    
    
    
    
    /**
     * Is Browser
     * 
     * Matches if it's the given browser or
     * not
     * 
     * @param string $browser
     * @return boolean
     */
    public function is_browser($browser = null) {
        
        if(is_null($browser)) {
            /* Nothing set - check not crawler, mobile, banned syndication reader */
            if($this->isBanned() === false && $this->isMobileDevice() === false && $this->isSyndicationReader() === false && $this->Crawler() === false) {
                /* Browser */
                return true;
            }
            return true;
        } else {
            /* Do it all in lower case */
            $browser = strtolower($browser);
            
            if(is_array($this->_arrBrowserMap) && array_key_exists($browser, $this->_arrBrowserMap)) {
                /* Replace browser value */
                $browser = strtolower($this->_arrBrowserMap[$browser]);
            }
            
            /* Get the browser details */
            return $browser == strtolower($this->browser());
        }
        
        /* Not matched */
        return false;
        
    }
    
    
    
    
    
    
    
    
    
    /**
     * Is Mobile
     * 
     * Matches if it's the given mobile or
     * not
     * 
     * @param string $mobile
     * @return bool
     */
    public function is_mobile($mobile = null) {
        
        if(is_null($mobile)) {
            return $this->isMobileDevice();
        } else {
            /* Do it all in lower case */
            $mobile = strtolower($mobile);
            
            if(is_array($this->_arrMobileMap) && array_key_exists($browser, $this->_arrMobileMap)) {
                /* Replace browser value */
                $mobile = strtolower($this->_arrMobileMap[$mobile]);
            }
            
            /* Get the browser details */
            return $mobile == strtolower($this->browser());
        }
        
    }
    
    
    
    
    
    
    /**
     * Is Referreal
     * 
     * Is this a referral from another site?
     * 
     * @access public
     * @return bool
    */
    public function is_referral() {
        if ( ! isset($_SERVER['HTTP_REFERER']) OR $_SERVER['HTTP_REFERER'] == '') {
            return false;
        }
        return true;
    }
    
    
    
    
    
    
    
    
    /**
     * Is Robot
     * 
     * Matches if it's the given robot or
     * not
     * 
     * @param string $robot
     * @return bool
     */
    public function is_robot($robot = null) {
        
        if(is_null($robot)) {
            return $this->crawler();
        } else {
            /* Do it all in lower case */
            $robot = strtolower($robot);
            
            if(is_array($this->_arrRobotMap) && array_key_exists($browser, $this->_arrRobotMap)) {
                /* Replace browser value */
                $robot = strtolower($this->_arrRobotMap[$robot]);
            }
            
            /* Get the browser details */
            return $robot == strtolower($this->browser());
        }
        
    }
    
    
    
    
    
    
    
    
    
    /**
     * Languages
     * 
     * Get the accepted languages
     * 
     * @return array
     */
    public function languages() {
        if (count($this->_arrLanguages) == 0) {
            $this->_set_languages();
        }

        return $this->_arrLanguages;
    }
    
    
    
    
    
    
    
    
    
    /**
     * Mobile
     * 
     * Get the mobile we're looking on
     * 
     * @return type 
     */
    public function mobile() {
        if($this->is_mobile()) {
            return $this->browser();
        } else {
            return '';
        }
    }
    
    
    
    
    
    
    
    /**
     * Referrer
     * 
     * Get the referrer
     *
     * @access public
     * @return string
     */
    public function referrer() {
        return ( ! isset($_SERVER['HTTP_REFERER']) OR $_SERVER['HTTP_REFERER'] == '') ? '' : trim($_SERVER['HTTP_REFERER']);
    }
    
    
    
    
    
    
    
    
    
    /**
     * Robot
     * 
     * Gets the name of the robot
     * 
     * @return string
     */
    public function robot() {
        if($this->is_robot()) {
            return $this->browser();
        } else {
            return '';
        }
    }
    
    
    
    
    
}

?>
<?php

define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 */

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

/*
 *--------------------------------------------------------------------
 * SYSTEM - APPLICATION - THEME - UPLOADS - ADMIN - TMP
 *--------------------------------------------------------------------
 *
 */
	$system_path = 'system';
	$application_folder = 'application';
	$theme_folder = 'themes';
	$upload_folder = 'uploads';
	$tmp_folder	= 'tmp';
	$home = dirname(__FILE__);
	define('HOMEPATH', $home);
/*
 * ---------------------------------------------------------------
 *   PREPARATION DEFINES FOLDER FUNCTION
 * ---------------------------------------------------------------
 */
function prep_folder($folder,$define)
{
	if (is_dir($folder))
	{
		define($define, $folder.'/');
	}
	else
	{
		if ( ! is_dir(BASEPATH.$folder.'/'))
		{
			exit("Your $define folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
		}

		define($define, BASEPATH.$folder.'/');
	}
}

// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// The PHP file extension
	// this global constant is deprecated.
	define('EXT', '.php');

	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));

	// Path to the front controller (this file)
	define('FCPATH', str_replace(SELF, '', __FILE__));

	// Name of the "system folder"
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));


	// The path to the "application" folder
	prep_folder($application_folder,'APPPATH');
	// The path to the "theme" folder
	prep_folder($theme_folder,'THEMEPATH');
	// The path to the "upload" folder
	prep_folder($upload_folder,'UPLOADPATH');
	// The path to the "tmp" folder
	// prep_folder($tmp_folder,'TMPPATH');
	

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */
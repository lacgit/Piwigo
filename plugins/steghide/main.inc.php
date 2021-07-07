<?php
/*
Version: 1.0
Plugin Name:	steghide
Plugin URI:		// Here comes a link to the Piwigo extension gallery, after
				// publication of your plugin. For auto-updates of the plugin.
Author:			// Good practice to put your forum username here.
This integrate the steghide to embed a signature to your pictures!'.

				// Do not use batch manager to generate derivatives,
				//	just delete and let piwigo to generate them one by one
*/
// Chech whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
 
// Define the path to our plugin.
define('STEGHIDE_ID',			basename(dirname(__FILE__)));
define('STEGHIDE_PATH' ,	 PHPWG_PLUGINS_PATH . STEGHIDE_ID . '/');
define('STEGHIDE_ADMIN',	 get_root_url() . 'admin.php?page=plugin-' . STEGHIDE_ID);
define('STEGHIDE_PUBLIC',	get_absolute_root_url() . make_index_url(array('section' => 'steghide')) . '/');
define('STEGHIDE_DIR',		 PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'steghide/');


// Hook on to an event to show the administration page.
//if (defined('IN_ADMIN')
//{

add_event_handler('get_admin_plugin_menu_links', 'steghide_admin_menu');
add_event_handler('SH_steghide_embed', 'steghide_embed');
//add_event_handler('loc_end_element_set_global', 'steghide_batch_global');
//add_event_handler('element_set_global_action', 'steghide_batch_global_submit');

// Add an entry to the 'Plugins' menu.
function steghide_admin_menu($menu) {
	array_push(
		$menu,
		array(
		'NAME'	=> 'steghide',
		'URL'	 => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin.php'
	));
	return $menu;
}

function steghide_embed($coverfile) {
	global $conf;
	global $logger;
	$stegdir = $conf['ext_steghide_dir'];
	$coversize = filesize($coverfile);
//	$logger->debug($covfile . ' size: ' . $covsize, 'plugin/steghide/main.inc.php');
	if ($coversize < 30000)
	{
		return false; //	is_array($returnarray);
	}

	$embedfile = STEGHIDE_PATH.'config/'.$conf['steghide_embed_file'];
	$ppfile	= STEGHIDE_PATH.'config/'.$conf['steghide_pass_file'];
	$stpp = file_get_contents($ppfile);
	$stpp = str_replace(array("\r", "\n"), '', $stpp);
	$steg = !isset($stegdir)||strlen($stegdir)==0 ? '' : $stegdir.'/';
	$steg .= 'steghide';
	$steg .= ' --embed --embedfile ' . $embedfile;
	$steg .= ' --compress 9 --encryption des';
	$steg .= ' --passphrase "' . $stpp . '"';
	$steg .= ' --force --quiet --coverfile ';
	$steg .= $coverfile . ' 2>&1';
//	$logger->debug($steg, 'plugin/steghide/main.inc.php');
	@exec($steg, $stegreturnarray);

	if (is_array($stegreturnarray) && (count($stegreturnarray)>0) )
	{
		$logger->error('', 'plugin/steghide/main.inc.php', $stegreturnarray);
		foreach ($stegreturnarray as $line)
			trigger_error($line, E_USER_WARNING);
	}

	return true;
}

/*
function steghide_batch_global()
{
	global $template;
 
//	load_language('plugin.lang', dirname(__FILE__).'/');
 
	// Assign the template for batch management
	$template->set_filename('CR_batch_global', dirname(__FILE__).'/batch_global.tpl');
 
	// Fetch all the copyrights and assign them to the template
	$query = sprintf(
		'SELECT `cr_id`,`name`
		FROM %s
		WHERE `visible`<>0
		;',
	COPYRIGHTS_ADMIN);
	$result = pwg_query($query);
	$CRoptions = array();
	while ($row = pwg_db_fetch_assoc($result)) {
		$CRoptions[$row['cr_id']] = $row['name'];
	}
	$template->assign('CRoptions', $CRoptions);
 
 
	// Add info on the "choose action" dropdown in the batch manager
	$template->append('element_set_global_plugins_actions', array(
		'ID' => 'copyrights', // ID of the batch manager action
		'NAME' => l10n('Edit copyright'), // Description of the batch manager action
		'CONTENT' => $template->parse('CR_batch_global', true)
	)
	);
}
*/
?>

<?php

// Chech whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Fetch the template.
global $template, $conf, $user;

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok											|
// +-----------------------------------------------------------------------+
check_status(ACCESS_ADMINISTRATOR);

if (!is_webmaster())
{
	array_push($page['errors'], l10n('This section is reserved for the webmaster'));
}
else
{
	$template->assign('stegconf',array('EXT_STEGHIDE_DIR' => $conf['ext_steghide_dir'],
																		 'STEGHIDE_PASS_FILE'	 => $conf['steghide_pass_file'],
																		 'STEGHIDE_EMBED_FILE' => $conf['steghide_embed_file'],));

	if (isset($_POST['submitpft']))
	{
		conf_update_param('ext_steghide_dir', $_POST['ext_steghide_dir']);
		conf_update_param('steghide_pass_file', $_POST['steghide_pass_file']);
		conf_update_param('steghide_embed_file', $_POST['steghide_embed_file']);
		$template->assign(
			'stegconf',
			array('EXT_STEGHIDE_DIR' => stripslashes($_POST['ext_steghide_dir']),
						'STEGHIDE_PASS_FILE' => stripslashes($_POST['steghide_pass_file']),
						'STEGHIDE_EMBED_FILE' => stripslashes($_POST['steghide_embed_file']),
			));
		array_push($page['infos'], l10n('Configuration update'));
	}
}

// Add our template to the global template
$template->set_filenames(
	array(
		'plugin_admin_content' => dirname(__FILE__).'/admin.tpl'
	)
);
 
// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>

<?php
if(!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  mediabakery
 * @author     Sebastian Tilch <http://www.mediabakery.de>
 * @package    mb_externlog
 * @license    GNU/LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'mb_externlogClient';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace(';{files_legend:', ';{mb_externlogClient_legend:hide},mb_externlogClient;{files_legend:', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['mb_externlogClient'] = 'mb_externlogAddress,mb_externlogPath,mb_externlogPort,mb_externlogCodifyengine, mb_externlogApiKey, mb_externlogMaxLogs';

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogClient'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogClient'],
	'inputType' => 'checkbox',
	'eval' => array('submitOnChange' => true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogAddress'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogAddress'],
	'inputType' => 'text',
	'default' => 'http://',
	'search' => true,
	'exclude' => true,
	'eval' => array(
		'trailingSlash' => false,
		'mandatory' => true,
		'tl_class' => 'w50'
	)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogPath'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogPath'],
	'inputType' => 'text',
	'exclude' => true,
	'eval' => array(
		'trailingSlash' => false,
		'tl_class' => 'w50'
	),
	'save_callback' => array( array(
			'tl_settingsMb_externlogClient',
			'checkFirstSlash'
		))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogPort'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogPort'],
	'inputType' => 'text',
	'search' => true,
	'default' => '80',
	'exclude' => true,
	'eval' => array(
		'rgxp' => 'digit',
		'mandatory' => true,
		'tl_class' => 'w50'
	)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogCodifyengine'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogCodifyengine'],
	'inputType' => 'select',
	'explanation' => 'security',
	'exclude' => true,
	'options_callback' => array(
		"tl_settingsMb_externlogClient",
		"callCodifyengines"
	),
	'eval' => array(
		'mandatory' => true,
		'tl_class' => 'w50'
	),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogMaxLogs'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogMaxLogs'],
	'inputType' => 'text',
	'default' => '5',
	'eval' => array(
		'mandatory' => true,
		'rgxp' => 'digit'
	)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['mb_externlogApiKey'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['mb_externlogApiKey'],
	'inputType' => 'text',
	'default' => '',
	'eval' => array(
		'mandatory' => true,
		'tl_class' => 'long',
		'minlength' => '32',
		'maxlength' => '64'
	)
);

class tl_settingsMb_externlogClient
{

	public function checkFirstSlash($strValue, DataContainer $dc)
	{
		if(empty($strValue))
		{
			return "";
		}
		else
		{
			if(preg_match("/^\//", $strValue))
			{
				return $strValue;
			}
			else
			{
				return "/" . $strValue;
			}
		}
	}

	public function callCodifyengines()
	{
		$arrReturn = array();

		foreach($GLOBALS["CTOCOM_ENGINE"] as $key => $value)
		{
			if($value["invisible"] == TRUE)
			{
				continue;
			}

			$arrReturn[$key] = $value["name"];
		}

		asort($arrReturn);

		return $arrReturn;
	}

}
?>
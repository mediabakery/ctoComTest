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
 * @package
 * @license    -
 * @filesource
 */

class ClientCom extends CtoCommunication
{
	/**
	 * @var ClientCom
	 */
	private static $objInstance = null;

	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * @return ClientCom
	 */
	public static function getInstance()
	{
		if(self::$objInstance === null)
		{
			self::$objInstance = new ClientCom();
		}
		return self::$objInstance;
	}

	public function setupClient()
	{

		$strAdress = $GLOBALS['TL_CONFIG']['mb_externlogAddress'];
		$strPath = $GLOBALS['TL_CONFIG']['mb_externlogPath'];
		$strPort = $GLOBALS['TL_CONFIG']['mb_externlogPort'];
		$strCodifyengine = $GLOBALS['TL_CONFIG']['mb_externlogCodifyengine'];
		$strApiKey = $GLOBALS['TL_CONFIG']['mb_externlogApiKey'];

		// Clean url
		$strPath = preg_replace("/\/\z/i", "", $strPath);
		$strPath = preg_replace("/ctoCommunication.php\z/i", "", $strPath);

		// Build path
		if($strPath == "")
		{
			$strUrl = $strAdress . ":" . $strPort . "/ctoCommunication.php";
		}
		else
		{
			$strUrl = $strAdress . ":" . $strPort . $strPath . "/ctoCommunication.php";
		}

		$this->setClient($strUrl, $strCodifyengine);
		$this->setApiKey($strApiKey);
		$this->setDebug(true);
		$this->setMeasurement(true);

		$this->setFileDebug('../../../tl_files/ctoCom/debug.txt');
		$this->setFileMeasurement('../../../tl_files/ctoCom/measurementDebug.txt');
	}

	public function doIt($strVal)
	{
		$arrData = array( array(
				'name' => 'var',
				'value' => $strVal
			));
		return $this->runServer('DOIT', $arrData);
	}

}
?>
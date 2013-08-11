<?php
/*------------------------------------------------------------------------
  Solidres - Hotel booking extension for Joomla
  ------------------------------------------------------------------------
  @Author    Solidres Team
  @Website   http://www.solidres.com
  @Copyright Copyright (C) 2013 Solidres. All Rights Reserved.
  @License   GNU General Public License version 3, or later
------------------------------------------------------------------------*/

defined('_JEXEC') or die;

/**
 * Class EnglishConceptTableLesson
 */
class EnglishConceptTableLesson extends JTable
{
	function __construct(&$_db)
	{
		parent::__construct('#__lessons', 'id', $_db);
	}
}


<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ngoc Nha
 * Date: 4/6/13
 * Time: 10:57 AM
 * To change this template use File | Settings | File Templates.
 */
// No direct access to this file
defined('_JEXEC') or die;

class OpenHrmViewMaritalStates extends OpenHrmViewAdmin
{
	protected $items;
	protected $pagination;

	/**
	 * Display function
	 */
	public function display($tpl = null)
	{
		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Set the tool bar
		$this->addToolbar();

		// Display the template
		parent::display($tpl);

		// Set the documents
		$this->setDocument();
	}

	public function addToolbar()
	{
		//$canDo	= OpenHrmHelperHrm::getActions();

		JToolbarHelper::title(JText::_('COM_OPENHRM_MARITALSTATE_TITLE'));
		JToolbarHelper::addNew('maritalstate.add');
		JToolbarHelper::editList('maritalstate.edit');

		//if ($canDo->get('core.admin'))
		{
			//JToolbarHelper::preferences('com_openhrm');
			//JToolbarHelper::divider();
		}
	}

	/**
	 * Get the view title.
	 *
	 * @return  string  The view title.
	 */
	public function getTitle()
	{
		return JText::_('COM_OPENHRM_MARITALSTATE_TITLE');
	}

	public function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_("COM_OPENHRM_MARITALSTATE_TITLE"));
	}
}

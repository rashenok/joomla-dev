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

class OpenHrmViewOrganizationInfo extends OpenHrmViewAdmin
{
	protected $state;
	protected $item;
	protected $form;

	/**
	 * Display function
	 */
	public function display($tpl = null)
	{
		$this->setLayout('edit');

		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		if (count($errors = $this->get('Errors')))
		{
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
		JHtml::_('behavior.tooltip');

		JToolbarHelper::title(JText::_('COM_OPENHRM_ORGANIZATIONINFO_TITLE'));
		JToolBarHelper::apply('organizationinfo.apply', 'JToolbar_Apply');
		JToolBarHelper::save('organizationinfo.save', 'JToolbar_Save');
		JToolBarHelper::cancel('organizationinfo.cancel', 'JToolbar_Cancel');
	}

	/**
	 * Get the view title.
	 *
	 * @return  string  The view title.
	 */
	public function getTitle()
	{
		return JText::_('COM_OPENHRM_ORGANIZATIONINFO_TITLE');
	}

	public function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_("COM_OPENHRM_ORGANIZATIONINFO_TITLE"));
	}
}

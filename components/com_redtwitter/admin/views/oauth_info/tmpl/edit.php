<?php
/**
 * @version    1.0.0
 * @package    Com_Redtwitter
 * @author     Ronni K. G. Christiansen<email@redweb.dk> - http://www.redcomponent.com
 * @copyright  Copyright (C) 2010 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 *             Developed by email@recomponent.com - redCOMPONENT.com
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_redtwitter/assets/css/redtwitter.css');
?>
<script type="text/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'oauth_info.cancel' || document.formvalidator.isValid(document.id('oauth-info-form'))) {
			Joomla.submitform(task, document.getElementById('oauth-info-form'));
		}
		else
		{
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_redtwitter&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="oauth-info-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_REDTWITTER_LEGEND_FOLLOWED_PROFILE'); ?></legend>
			<ul class="adminformlist">

				<li><?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?></li>
				<li><?php echo $this->form->getLabel('consumer_key'); ?>
					<?php echo $this->form->getInput('consumer_key'); ?></li>
				<li><?php echo $this->form->getLabel('consumer_secret'); ?>
					<?php echo $this->form->getInput('consumer_secret'); ?></li>
				<li><?php echo $this->form->getLabel('access_token'); ?>
					<?php echo $this->form->getInput('access_token'); ?></li>
				<li><?php echo $this->form->getLabel('access_token_secret'); ?>
					<?php echo $this->form->getInput('access_token_secret'); ?></li>
				<li><?php echo $this->form->getLabel('state'); ?>
					<?php echo $this->form->getInput('state'); ?></li>

			</ul>
		</fieldset>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>

	<style type="text/css">
		.adminformlist li {
			clear : both;
		}
	</style>
</form>
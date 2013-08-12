<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ngoc Nha
 * Date: 4/6/13
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php //echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<?php //if (!empty( $this->sidebar)) : ?>
<div id="ec-panel-left" class="span2">
	<div id="ec-sidebar-navigate" class="span2">
		<?php //echo $this->sidebar; ?>
	</div>
</div>
<div id="ec-panel-right" class="span10">
<?php //else : ?>
<!--	<div id="ec-main-container">-->
<?php //endif;?>
	<div class="ec-main-container">
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				jQuery('#itemForm').validate();
			});
			Joomla.submitbutton = function(task)
			{
				if (task == 'englishconcept.cancel' || jQuery('#itemForm').valid())
				{
					<?php //echo $this->form->getField('book')->save(); ?>
					Joomla.submitform(task, document.getElementById('itemForm'));
				}
				else {
					alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
				}
			}
		</script>
		<form enctype="multipart/form-data"
			action="<?php JRoute::_('index.php?option=com_englishconcept&view=englishconcept'); ?>" method="post" name="itemForm" id="itemForm"
			class="form-validate form-horizontal">
			<fieldset>
				<ul class="nav nav-tabs">
					<li class="active"><a href="#general" data-toggle="tab"><?php echo JText::_('SR_NEW_GENERAL_INFO')?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="general">

						<div class="control-group">
							<?php echo $this->form->getLabel('id'); ?>
							<div class="controls">
								<?php echo $this->form->getInput('id'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $this->form->getLabel('book_name'); ?>
							<div class="controls">
								<?php echo $this->form->getInput('book_name'); ?>
							</div>
						</div>

					</div>
				</div>
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="jform[id]" value="<?php if(isset($this->item->id)){echo $this->item->id;}?>" />
				<?php echo JHtml::_('form.token'); ?>
			</fieldset>
		</form>
	</div>
</div>

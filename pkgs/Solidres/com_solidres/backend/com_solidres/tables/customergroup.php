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
 * Customer table class
 *
 * @package     Solidres
 * @subpackage	CustomerGroup
 * @since		0.1.0
 */
class SolidresTableCustomerGroup extends JTable
{
	function __construct(&$_db)
	{
		parent::__construct('#__sr_customer_groups', 'id', $_db);
	}

	/**
	 * Method to delete a row from the database table by primary key value.
	 *
	 * @param   mixed    $pk  An optional primary key value to delete.  If not set the
	 *                        instance property value is used.
	 *
	 * @return  boolean  True on success.
	 * @since   0.3.0
	 */
	public function delete($pk = null)
	{
		$k = $this->_tbl_key;
		$pk = (is_null($pk)) ? $this->$k : $pk;
		$query = $this->_db->getQuery(true);
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_solidres/models', 'UsersModel');

		// Take care of Customer records
		$query->select('COUNT(id)')->from($this->_db->quoteName('#__sr_customers'))->where('customer_group_id = ' . $pk);
		$this->_db->setQuery($query);
		$result = (int) $this->_db->loadResult();
		if($result > 0)
		{
			$e = new JException(JText::sprintf('SR_ERROR_CUSTOMER_GROUP_CONTAINS_CUSTOMER', $this->name));
			$this->setError($e);
			return false;
		}

		// Delete all prices
		$query->clear();
		$query->delete($this->_db->quoteName('#__sr_prices'))->where('customer_group_id = ' . $this->_db->quote($pk));
		$this->_db->setQuery($query)->execute();

		// Take care of Coupon
		$couponsModel = JModelLegacy::getInstance('Coupons', 'SolidresModel', array('ignore_request' => true));
		$couponModel = JModelLegacy::getInstance('Coupon', 'SolidresModel', array('ignore_request' => true));
		$couponsModel->setState('filter.customer_group_id', $pk);
		$coupons = $couponsModel->getItems();

		foreach ($coupons as $coupon)
		{
			$couponModel->delete($coupon->id);
		}

		// Delete it
		return parent::delete($pk);
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.0.4
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k.'='.implode(' OR '.$k.'=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time')) {
			$checkin = '';
		}
		else {
			$checkin = ' AND (checked_out = 0 OR checked_out = '.(int) $userId.')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `'.$this->_tbl.'`' .
				' SET state = '.(int) $state .
				' WHERE ('.$where.')' .
				$checkin
		);
		$this->_db->execute();

		// Check for a database error.
		if ($this->_db->getErrorNum()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin the rows.
			foreach($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks)) {
			$this->state = $state;
		}

		$this->setError('');
		return true;
	}
}


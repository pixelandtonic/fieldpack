<?php if (! defined('BASEPATH')) exit('No direct script access allowed');


if (! class_exists('PT_Fieldtype'))
{
	require PATH_THIRD.'fieldpack/pt_fieldtype.php';
}


/**
 * Field pack - Multi-select Class
 *
 * @package   P&T Field Pack
 * @author    Pixel & Tonic Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2013 Pixel & Tonic, Inc
 */
class Fieldpack_multiselect_ft extends PT_Multi_Fieldtype {

	var $info = array(
		'name'     => 'Field pack - Multiselect',
		'version'  => PT_FIELDPACK_VER
	);

	var $class = 'multiselect';
	var $total_option_levels = 2;

	// --------------------------------------------------------------------

	/**
	 * Install
	 */
	function install()
	{
		if (! class_exists('FF2EE2'))
		{
			require PATH_THIRD.'fieldpack/ff2ee2/ff2ee2.php';
		}

		new FF2EE2(array('ff_multiselect', 'fieldpack_multiselect'));

		$this->helper->convert_types('pt_multiselect', 'fieldpack_multiselect');
		$this->helper->uninstall_fieldtype('pt_multiselect');

		return array();
	}

	// --------------------------------------------------------------------

	/**
	 * Display Field
	 */
	function _display_field($data, $field_name)
	{
		global $DSP;

		$this->prep_field_data($data);

		$r = form_hidden($field_name, 'n')
		   . form_multiselect($field_name.'[]', $this->settings['options'], $data);

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	 * Save Field
	 */
	function save($data)
	{
		$data = is_array($data) ? implode("\n", $data) : '';
		return parent::save($data);
	}

	/**
	 * Save Cell
	 */
	function save_cell($data)
	{
		return $this->save($data);
	}

}

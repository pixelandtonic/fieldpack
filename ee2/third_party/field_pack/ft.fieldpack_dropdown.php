<?php if (! defined('BASEPATH')) exit('No direct script access allowed');


if (! class_exists('PT_Fieldtype'))
{
	require PATH_THIRD.'fieldpack/pt_fieldtype.php';
}


/**
 * Field pack - Dropdown Class
 *
 * @package   P&T Field Pack
 * @author    Pixel & Tonic Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2013 Pixel & Tonic, Inc
 */
class Fieldpack_dropdown_ft extends PT_Multi_Fieldtype {

	var $info = array(
		'name'     => 'Field pack - Dropdown',
		'version'  => PT_FIELDPACK_VER
	);

	var $class = 'fieldpack_dropdown';
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

		new FF2EE2(array('ff_select', 'fieldpack_dropdown'));

		$this->helper->convert_types('pt_dropdown', 'fieldpack_dropdown');
		$this->helper->uninstall_fieldtype('pt_dropdown');

		return array();
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Field Data
	 */
	function prep_field_data(&$data)
	{
		if (is_array($data))
		{
			$data = array_shift($data);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Display Field
	 */
	function _display_field($data, $field_name)
	{
		$this->prep_field_data($data);

		return form_dropdown($field_name, $this->settings['options'], $data);
	}

	/**
	 * Display Cell
	 */
	function display_cell($data)
	{
		if (is_string($data)) $data = str_replace('"', '&quot;', html_entity_decode($data, ENT_QUOTES));

		return $this->_display_field($data, $this->cell_name);
	}


	// --------------------------------------------------------------------

	/**
	 * Replace Tag
	 */
	function replace_tag($data)
	{
		$this->prep_field_data($data);

		return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Option Label
	 */
	function replace_label($data)
	{
		$this->prep_field_data($data);

		$label = $this->_find_label($data, $this->settings['options']);
		return $label ? $label : '';
	}

	/**
	 * Find Label
	 */
	private function _find_label($data, $options)
	{
		foreach($options as $name => $label)
		{
			if (is_array($label) && ($sublabel = $this->_find_label($data, $label)) !== FALSE)
			{
				return $sublabel;
			}
			else if ((string) $data === (string) $name)
			{
				return $label;
			}
		}
		return FALSE;
	}

}

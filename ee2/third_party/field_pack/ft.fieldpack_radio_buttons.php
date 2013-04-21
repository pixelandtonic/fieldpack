<?php if (! defined('BASEPATH')) exit('No direct script access allowed');


if (! class_exists('PT_Fieldtype'))
{
	require PATH_THIRD.'fieldpack/pt_fieldtype.php';
}


/**
 * Field pack - Radio Buttons Class
 *
 * @package   P&T Field Pack
 * @author    Pixel & Tonic Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2013 Pixel & Tonic, Inc
 */
class Fieldpack_radio_buttons_ft extends PT_Multi_Fieldtype {

	var $info = array(
		'name'     => 'Fieldpack: Radio Buttons',
		'version'  => PT_FIELDPACK_VER
	);

	var $class = 'fieldpack_radio_buttons';

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

		new FF2EE2(array('ff_radio_group', 'fieldpack_radio_buttons'));

		$this->helper->convert_types('pt_radio_buttons', 'fieldpack_radio_buttons');
		$this->helper->uninstall_fieldtype('pt_radio_buttons');

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

		$r = '';

		foreach($this->settings['options'] as $option_name => $option)
		{
			$selected = ((string) $option_name === (string) $data);
			$r .= '<label>'
			    .   form_radio($field_name, $option_name, $selected)
			    .   NBS . $option
			    . '</label>';
		}

		return $r;
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

		return $this->settings['options'][$data];
	}

}

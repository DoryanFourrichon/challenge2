<?php

namespace ACA\WC\Column\ProductVariation;

use AC;
use ACA\WC\Editing;
use ACA\WC\Settings;
use ACP;

/**
 * @since 3.0
 */
class Variation extends AC\Column
	implements ACP\Editing\Editable, ACP\Export\Exportable {

	public function __construct() {
		$this->set_type( 'variation_attributes' );
		$this->set_original( true );
	}

	/**
	 * @return Settings\ProductVariation\Variation|false
	 */
	public function get_setting_variation() {
		$setting = $this->get_setting( 'variation_display' );

		if ( ! $setting instanceof Settings\ProductVariation\Variation ) {
			return false;
		}

		return $setting;
	}

	public function register_settings() {
		$this->add_setting( new Settings\ProductVariation\Variation( $this ) );
	}

	public function editing() {
		return new Editing\ProductVariation\Variation();
	}

	public function export() {
		return new ACP\Export\Model\StrippedValue( $this );
	}

}
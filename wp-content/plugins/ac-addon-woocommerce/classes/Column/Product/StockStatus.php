<?php

namespace ACA\WC\Column\Product;

use AC;
use ACA\WC\Editing;
use ACA\WC\Filtering;
use ACP;

/**
 * @since 1.0
 */
class StockStatus extends AC\Column\Meta
	implements ACP\Sorting\Sortable, ACP\Editing\Editable, ACP\Filtering\Filterable, ACP\Search\Searchable {

	public function __construct() {
		$this->set_type( 'column-wc-stock-status' );
		$this->set_label( __( 'Stock Status', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return '_stock_status';
	}

	public function get_value( $post_id ) {
		$product = wc_get_product( $post_id );

		if ( ! $product ) {
			return $this->get_empty_char();
		}

		switch ( $this->get_raw_value( $post_id ) ) {

			case 'instock' :
				return ac_helper()->icon->yes( __( 'In stock', 'codepress-admin-columns' ) );
			case 'outofstock' :
				return ac_helper()->icon->no( __( 'Out of stock', 'codepress-admin-columns' ) );
			case 'onbackorder' :
				return ac_helper()->icon->dashicon( [ 'icon' => 'backup', 'class' => 'yellow', 'tooltip' => __( 'On backorder', 'codepress-admin-columns' ) ] );
			default :
				return $this->get_empty_char();
		}
	}

	public function get_raw_value( $post_id ) {
		return wc_get_product( $post_id )->get_stock_status();
	}

	public function sorting() {
		return new ACP\Sorting\Model\Post\Meta( $this->get_meta_key() );
	}

	public function editing() {
		return new Editing\Product\Stock();
	}

	public function filtering() {
		return new Filtering\Product\StockStatus( $this );
	}

	public function search() {
		return new \ACA\WC\Search\Product\StockStatus();
	}

	public function get_supported_types() {
		return [ 'simple' ];
	}

}
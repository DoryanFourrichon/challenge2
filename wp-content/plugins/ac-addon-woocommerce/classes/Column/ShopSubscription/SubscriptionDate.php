<?php

namespace ACA\WC\Column\ShopSubscription;

use AC;
use ACA\WC;
use ACA\WC\Export;
use ACA\WC\Settings;
use ACA\WC\Sorting;
use ACP;

class SubscriptionDate extends AC\Column\Meta
	implements ACP\Export\Exportable, ACP\Sorting\Sortable, ACP\Search\Searchable, ACP\Editing\Editable {

	/**
	 * @var WC\Field\ShopSubscription\SubscriptionDate
	 */
	private $field;

	public function __construct() {
		$this->set_label( __( 'Date', 'codepress-admin-columns' ) )
		     ->set_type( 'column-wc-subscription_date' )
		     ->set_group( 'woocommerce' );
	}

	public function register_settings() {
		$this->add_setting( new Settings\ShopSubscription\SubscriptionDate( $this ) );
	}

	public function get_meta_key() {
		if ( ! $this->get_field() ) {
			return false;
		}

		return $this->get_field()->get_meta_key();
	}

	public function export() {
		if ( ! $this->get_field() ) {
			return new ACP\Export\Model\Disabled( $this );
		}

		return $this->get_field()->export();
	}

	public function sorting() {
		if ( ! $this->get_field() ) {
			return new ACP\Sorting\Model\Disabled();
		}

		return $this->get_field()->sorting();
	}

	public function search() {
		if ( ! $this->get_field() ) {
			return false;
		}

		return $this->get_field()->search();
	}

	public function editing() {
		return $this->get_field()
			? $this->get_field()->editing()
			: false;
	}

	private function set_field() {
		$type = $this->get_setting( 'date_type' )->get_value();

		foreach ( $this->get_fields() as $field ) {
			if ( $field->get_key() === $type ) {
				$this->field = $field;
				break;
			}
		}
	}

	/**
	 * @return WC\Field\ShopSubscription\SubscriptionDate|false
	 */
	public function get_field() {
		if ( null === $this->field ) {
			$this->set_field();
		}

		return $this->field;
	}

	/**
	 * @return WC\Field\ShopSubscription\SubscriptionDate[]
	 */
	public function get_fields() {
		return [
			new WC\Field\ShopSubscription\SubscriptionDate\EndDate( $this ),
			new WC\Field\ShopSubscription\SubscriptionDate\NextPayment( $this ),
			new WC\Field\ShopSubscription\SubscriptionDate\StartDate( $this ),
			new WC\Field\ShopSubscription\SubscriptionDate\TrialEnd( $this ),
		];
	}

}
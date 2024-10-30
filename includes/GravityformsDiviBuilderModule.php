<?php

class GFDBM_GravityformsDiviBuilderModule extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.00
	 *
	 * @var string
	 */
	public $gettext_domain = 'gfdbm-module-for-gravity-forms-in-divi-builder';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.00
	 *
	 * @var string
	 */
	public $name = 'module-for-gravity-forms-in-divi-builder';

	/**
	 * The extension's version
	 *
	 * @since 1.00
	 *
	 * @var string
	 */
	public $version = '1.01';

	/**
	 * GFDBM_GravityformsDiviBuilderModule constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'module-for-gravity-forms-in-divi-builder', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new GFDBM_GravityformsDiviBuilderModule;

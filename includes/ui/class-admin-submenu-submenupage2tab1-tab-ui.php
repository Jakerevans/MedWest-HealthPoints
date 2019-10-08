<?php
/**
 * MedWesthealthpoints_Settings_Settings1_Tab Tab - class-admin-settings-libraries-tab-ui.php.
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWesthealthpoints_Settings_Settings1_Tab', false ) ) :

	/**
	 * MedWesthealthpoints_Settings_Settings1_Tab Class.
	 */
	class MedWesthealthpoints_Settings_Settings1_Tab {

		/**
		 * Class Constructor
		 */
		public function __construct() {
			require_once MEDWESTHEALTHPOINTS_CLASS_DIR . 'class-admin-ui-template.php';
			require_once MEDWESTHEALTHPOINTS_CLASS_DIR . 'class-submenu-two-tab-one-form.php';

			// Instantiate the class.
			$this->template = new MedWesthealthpoints_Admin_UI_Template();
			$this->form     = new MedWesthealthpoints_Settings1_Form();
			$this->output_open_admin_container();
			$this->output_tab_content();
			$this->output_close_admin_container();
			$this->output_admin_template_advert();
		}

		/**
		 * Opens the admin container for the tab
		 */
		private function output_open_admin_container() {
			$title    = 'Submenu 2 Tab 1';
			$icon_url = MEDWESTHEALTHPOINTS_ROOT_IMG_URL . 'settings.svg';

			echo $this->template->output_open_admin_container( $title, $icon_url );

		}

		/**
		 * Outputs actual tab contents
		 */
		private function output_tab_content() {
			echo $this->form->output_settings1_form();
		}

		/**
		 * Closes admin container.
		 */
		private function output_close_admin_container() {
			echo $this->template->output_close_admin_container();
		}

		/**
		 * Outputs advertisment area.
		 */
		private function output_admin_template_advert() {
			echo $this->template->output_template_advert();
		}


	}
endif;

// Instantiate the class.
$cm = new MedWesthealthpoints_Settings_Settings1_Tab();

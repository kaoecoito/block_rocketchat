<?php

require_once(dirname(__FILE__) . '/../../config.php');

/**
 * Rocket.Chat block config form definition
 *
 * @package    contrib
 * @subpackage block_rocketchat
 * @copyright  www.sistemasprofissionais.com.br
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_rocketchat_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        $mform->addElement('header', 'configheader', get_string('settingheader', 'block_rocketchat'));

        $mform->addElement('text', 'config_rocketchat_url', "URL");
        $mform->setDefault('config_rocketchat_url', '');

        $mform->addElement('text', 'config_rocketchat_department', "Departamento");
        $mform->setDefault('config_rocketchat_departamento', '');

    }

}
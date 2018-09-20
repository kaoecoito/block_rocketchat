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

class block_rocketchat extends block_base {

    /**
     * Sets the block title
     *
     * @return none
     */
    function init() {
        $this->title = get_string('pluginname', 'block_rocketchat');
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    function applicable_formats() {
        return array('all' => true);
    }

    /**
     * Constrols global configurability of block
     *
     * @return bool
     */
    function instance_allow_config() {
        return false;
    }

    /**
     * Constrols global configurability of block
     *
     * @return bool
     */
    function has_config() {
        return false;
    }

    /**
     * Constrols if a block header is shown based on instance configuration
     *
     * @return bool
     */
    function hide_header() {
        return false;
    }

    /**
     * Constrols the block title based on instance configuration
     *
     * @return bool
     */
    function specialization() {
        $this->title = "Rocket.Chat";
    }

    function get_content() {
        global $USER, $COURSE;

        if (isset($this->content)) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        $url = $this->config->rocketchat_url;
        if (!$url || $url=='/') {
            return $this->content;
        }
        if (substr($url,strlen($url)-1, 1) == '/') {
            $url = substr($url,0, strlen($url)-1);
        }

        $department = $this->config->rocketchat_department;

        $script = "";
        $script .= "<script type=\"text/javascript\">
        (function(w, d, s, u) {
                w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
                var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
                j.async = true; j.src = '$url/packages/rocketchat_livechat/assets/rocketchat-livechat.min.js?_=201702160944';
                h.parentNode.insertBefore(j, h);
        })(window, document, 'script', '$url/livechat');
        </script>\n\n";

        $script .= "<script type=\"text/javascript\">";

        $script .= "RocketChat(function() {\n";

        if ($department) {
            $script .= "\tthis.setDepartment('$department');\n";
        }

        if ($USER!=null && $USER->id!=null && !isguestuser($USER)) {
            $chatLogin = array(
                'token' => md5($USER->username),
                'name' => trim($USER->firstname.' '.$USER->lastname),
                'email' => $USER->email
            );
            $script .= "\tthis.registerGuest(".json_encode($chatLogin).");\n";
        }
        if ($COURSE!=null && $COURSE->id!=null) {
            $script .= "\tthis.setCustomField('COURSE_NAME','".$COURSE->fullname."');\n";
        }

        $script .= "\n});\n</script>";

        $this->content->text = $script;
        return $this->content;
    }

}
<?php
class My_Form_Decorator_Tooltip extends Zend_Form_Decorator_Abstract
{
    public function render($content) {
        $data = parent::render('');

        $config = Zend_Registry::get('config');
        $tooltip = ' <span class="field-target" id="field-target-' . $this->getOption('field-target') . '">'
                    . "$config->display->help_icon" . '</span></label>';

        $data = str_replace('</label>', $tooltip, $data);
        return $data . $content;
    }
}
?>
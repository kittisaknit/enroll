<?php
/**
 * @filesource modules/enroll/views/settings.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Enroll\Settings;

use Kotchasan\Html;
use Kotchasan\Language;

/**
 * module=enroll-settings
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * ฟอร์มตั้งค่า Enroll
     *
     * @return string
     */
    public function render()
    {
        // form
        $form = Html::create('form', array(
            'id' => 'setup_frm',
            'class' => 'setup_frm',
            'autocomplete' => 'off',
            'action' => 'index.php/enroll/model/settings/submit',
            'onsubmit' => 'doFormSubmit',
            'ajax' => true,
            'token' => true,
        ));
        $fieldset = $form->add('fieldset', array(
            'title' => '{LNG_Module settings}',
        ));
        // enroll_study_plan_count
        $fieldset->add('number', array(
            'id' => 'enroll_study_plan_count',
            'labelClass' => 'g-input icon-number',
            'itemClass' => 'item',
            'label' => '{LNG_Study plan}',
            'comment' => '{LNG_Number of study plans that can be selected}',
            'value' => isset(self::$cfg->enroll_study_plan_count) ? self::$cfg->enroll_study_plan_count : 1,
        ));
        // enroll_w
        $fieldset->add('text', array(
            'id' => 'enroll_w',
            'labelClass' => 'g-input icon-width',
            'itemClass' => 'item',
            'label' => '{LNG_Size of} {LNG_Image} ({LNG_Width})',
            'comment' => '{LNG_Image size is in pixels} ({LNG_resized automatically})',
            'value' => isset(self::$cfg->enroll_w) ? self::$cfg->enroll_w : 600,
        ));
        // enroll_csv_language
        $fieldset->add('select', array(
            'id' => 'enroll_csv_language',
            'labelClass' => 'g-input icon-excel',
            'itemClass' => 'item',
            'label' => '{LNG_Export}',
            'comment' => '{LNG_CSV file language encoding}',
            'options' => Language::get('CSV_LANGUAGES'),
            'value' => isset(self::$cfg->enroll_csv_language) ? self::$cfg->enroll_csv_language : 'UTF-8',
        ));
        // enroll_country
        $fieldset->add('select', array(
            'id' => 'enroll_country',
            'labelClass' => 'g-input icon-world',
            'itemClass' => 'item',
            'label' => '{LNG_Country}',
            'comment' => '{LNG_Country for province selection information}',
            'options' => Language::get('COUNTRIES'),
            'value' => isset(self::$cfg->enroll_country) ? self::$cfg->enroll_country : 'TH',
        ));
        $fieldset = $form->add('fieldset', array(
            'title' => '{LNG_Recruitment}',
        ));
        $groups = $fieldset->add('groups', array(
            'comment' => '{LNG_Date of application opening-closing}',
        ));
        // enroll_begin
        $groups->add('date', array(
            'id' => 'enroll_begin',
            'labelClass' => 'g-input icon-calendar',
            'itemClass' => 'width50',
            'label' => '{LNG_From}',
            'value' => isset(self::$cfg->enroll_begin) ? self::$cfg->enroll_begin : null,
        ));
        // enroll_end
        $groups->add('date', array(
            'id' => 'enroll_end',
            'labelClass' => 'g-input icon-calendar',
            'itemClass' => 'width50',
            'label' => '{LNG_To}',
            'value' => isset(self::$cfg->enroll_end) ? self::$cfg->enroll_end : null,
        ));
        $fieldset->add('button', array(
            'id' => 'enroll_reset',
            'itemClass' => 'item',
            'labelClass' => 'g-input',
            'class' => 'red button wide center icon-reset',
            'label' => '&nbsp;',
            'value' => '{LNG_Reset database}',
        ));
        $fieldset = $form->add('fieldset', array(
            'class' => 'submit',
        ));
        // submit
        $fieldset->add('submit', array(
            'class' => 'button save large icon-save',
            'value' => '{LNG_Save}',
        ));
        // Javascript
        $form->script('initEnrollSettings();');
        // คืนค่า HTML
        return $form->render();
    }
}

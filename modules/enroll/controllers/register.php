<?php
/**
 * @filesource modules/enroll/controllers/register.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Enroll\Register;

use Gcms\Login;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=enroll-register
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{
    /**
     * ฟอร์มลงทะเบียน
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // ข้อความ title bar
        $this->title = Language::get('Registration form');
        // เลือกเมนู
        $this->menu = 'enroll';
        // สมาชิก
        $login = Login::isMember();
        // ตรวจสอบรายการที่เลือก
        $enroll = \Enroll\Register\Model::get($request->request('id')->toInt());
        if ($enroll) {
            // วันนี้
            $today = date('Y-m-d');
            $can_new = $enroll->id == 0 && (empty(self::$cfg->enroll_begin) || empty(self::$cfg->enroll_end) || ($today >= self::$cfg->enroll_begin && $today <= self::$cfg->enroll_end));
            // ใหม่ หรือ ผู้ดูแล
            if ($can_new || Login::checkPermission($login, 'can_manage_enroll')) {
                // แสดงผล
                $section = Html::create('section', array(
                    'class' => 'content_bg',
                ));
                // breadcrumbs
                $breadcrumbs = $section->add('div', array(
                    'class' => 'breadcrumbs',
                ));
                $ul = $breadcrumbs->add('ul');
                $ul->appendChild('<li><a class="icon-register" href="index.php">{LNG_Home}</a></li>');
                $ul->appendChild('<li><span>{LNG_Enroll}</span></li>');
                $section->add('header', array(
                    'innerHTML' => '<h2 class="icon-write">'.$this->title.'</h2>',
                ));
                // แสดงฟอร์ม
                $section->appendChild(createClass('Enroll\Register\View')->render($request, $enroll, $login));
                // คืนค่า HTML
                return $section->render();
            }
        }
        // 404
        return \Index\Error\Controller::execute($this);
    }
}

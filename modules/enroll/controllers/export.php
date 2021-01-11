<?php
/**
 * @filesource modules/enroll/controllers/export.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Enroll\Export;

use Kotchasan\Http\Request;

/**
 * export.php?module=enroll-export&typ=csv|print
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{

    /**
     * export
     *
     * @param Request $request
     */
    public function export(Request $request)
    {
        $typ = $request->get('typ')->toString();
        if ($typ === 'csv') {
            // CSV
            return \Enroll\Csv\View::execute($request);
        }
        return false;
    }
}

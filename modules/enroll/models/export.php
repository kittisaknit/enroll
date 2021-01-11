<?php
/**
 * @filesource modules/enroll/models/export.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Enroll\Export;

use Kotchasan\Database\Sql;

/**
 * export.php?module=enroll-export&typ=csv|print
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * ส่งออกข้อมูล CSV
     *
     * @param array $params
     *
     * @return array
     */
    public static function csv($params)
    {
        $where = array();
        if ($params['level'] > 0) {
            $where[] = array('E.level', $params['level']);
        }
        $q1 = \Kotchasan\Model::createQuery()
            ->select('enroll_id', Sql::GROUP_CONCAT('N.topic', 'plan'))
            ->from('enroll_plan D')
            ->join('enroll E', 'INNER', array('E.id', 'D.enroll_id'))
            ->join('category N', 'LEFT', array(array('N.type', 'enroll'), array('N.category_id', 'D.value'), array('N.sub_category', 'E.level')))
            ->groupBy('D.enroll_id');
        if ($params['level'] > 0 && $params['plan'] > 0) {
            $q1->where(array('D.value', $params['plan']));
        }
        $query = \Kotchasan\Model::createQuery()
            ->select('E.level', 'N.plan', 'E.title', 'E.name', 'E.id_card', 'E.birthday', 'E.phone', 'E.email', 'E.nationality', 'E.religion', 'E.address', 'D.district', 'A.amphur', 'P.province', 'E.zipcode', 'E.parent', 'E.original_school', 'E.academic_results')
            ->from('enroll E')
            ->join('province P', 'LEFT', array('P.id', 'E.provinceID'))
            ->join('amphur A', 'LEFT', array(array('A.id', 'E.amphurID'), array('A.province_id', 'P.id')))
            ->join('district D', 'LEFT', array(array('D.id', 'E.districtID'), array('D.amphur_id', 'A.id')))
            ->where($where)
            ->order($params['sort']);
        if ($params['level'] > 0 && $params['plan'] > 0) {
            $query->join(array($q1, 'N'), 'INNER', array('N.enroll_id', 'E.id'));
        } else {
            $query->join(array($q1, 'N'), 'LEFT', array('N.enroll_id', 'E.id'));
        }
        return $query->cacheOn()->execute();
    }
}

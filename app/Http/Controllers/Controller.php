<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $row;

    // 获取所有号码
    protected function getAllNumber()
    {
        return DB::table('lotteryData');
    }

    // 获取限定条数的号码记录
    protected function getResultLimitRecord($limit)
    {
        return DB::table('lotteryResult')->limit($limit)->orderBy('number', 'desc')->get();
    }


    /*
     * 判断开奖数据是否是-四重
     */
    protected function fourDouble()
    {
        $vv = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        $n_arr = array_count_values($vv);
        foreach ($n_arr as $k => $v) {
            if ($v >= 4) return true;
        }
        return false;
    }

    // 上数
    protected function upNumber($num)
    {
        $key1 = 0;
        $vv = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        foreach ($num as $key => $value) {
            if (in_array($value, $vv)) {
                $key1 = $key1 + 1;
            }
        }
        return $key1;
    }

    // 三数合
    protected function threeHe($value)
    {
        $getValue = $this->threeCountValue($this->row->r1, $this->row->r2, $this->row->r3);
        if (in_array($getValue, $value)) {
            //    echo "<br />--合数：".$getValue ;
            return false;
        }

        $getValue = $this->threeCountValue($this->row->r1, $this->row->r2, $this->row->r4);
        if (in_array($getValue, $value)) {
            return false;
        }

        $getValue = $this->threeCountValue($this->row->r1, $this->row->r3, $this->row->r4);
        if (in_array($getValue, $value)) {
            return false;
        }

        $getValue = $this->threeCountValue($this->row->r2, $this->row->r3, $this->row->r4);
        if (in_array($getValue, $value)) {
            return false;
        }
        return true;
    }

    // 检测三兄弟
    protected function threeBrother()
    {
        $arr = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        $result = array_unique($arr);

        // 如果数组为空或只有两个元素，直接返回true
        if (count($result) <= 2) return false;

        $sorted = $result;
        sort($sorted);

        for ($i = 1; $i < count($sorted) - 1; $i++) {
            $current = $sorted[$i - 1];
            $next = $sorted[$i];
            $three = $sorted[$i + 1];

            $a1 = $next - $current;
            $a2 = $three - $next;

            if ($a1 == 1 && $a1 == $a2) {
                return true;
            }

            if (count($sorted) == 3) {
                // 循环相邻：当前是最大值，下一个是最小值
                if ($current == 0 && $next == 1 && $three == 9) return true;
                if ($current == 0 && $next == 8 && $three == 9) return true;
            }

            if (count($sorted) == 4) {
                if ($current == 0 && $sorted[1] == 1 && $sorted[3] == 9) return true;
                if ($current == 0 && $sorted[2] == 8 && $sorted[3] == 9) return true;
            }
        }




        return false;
    }


    // 检测四兄弟
    protected function fourBrother()
    {
        $arr1 = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        sort($arr1);

        $a1 = $arr1[0] + 0;
        $a2 = $arr1[0] + 1;
        $a3 = $arr1[0] + 2;
        $a4 = $arr1[0] + 3;

        $b1 = $arr1[0] - 0;
        $b2 = $arr1[0] - 1;
        $b3 = $arr1[0] - 2;
        $b4 = $arr1[0] - 3;

        if ($arr1[0] == $a1 && $arr1[1] == $a2 && $arr1[2] == $a3 && $arr1[3] == $a4) {
            return true;
        }

        if ($arr1[0] == $b1 && $arr1[1] == $b2 && $arr1[2] == $b3 && $arr1[3] == $b4) {
            return true;
        }

        if ($arr1[0] == 0 && $arr1[1] == 7 && $arr1[2] == 8 && $arr1[3] == 9) {
            return true;
        }

        if ($arr1[0] == 0 && $arr1[1] == 1 && $arr1[2] == 8 && $arr1[3] == 9) {
            return true;
        }

        if ($arr1[0] == 0 && $arr1[1] == 1 && $arr1[2] == 2 && $arr1[3] == 9) {
            return true;
        }
        return false;
    }

    // 四单
    protected function fourSingle()
    {
        if ($this->row->r1 % 2 == 1) {
            if ($this->row->r2 % 2 == 1) {
                if ($this->row->r3 % 2 == 1) {
                    if ($this->row->r4 % 2 == 1) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    protected function fourSingleValue($val)
    {
        if ($val == 1) return ($this->row->r1 % 2) ? true : false;
        if ($val == 2) return ($this->row->r2 % 2) ? true : false;
        if ($val == 3) return ($this->row->r3 % 2) ? true : false;
        if ($val == 4) return ($this->row->r4 % 2) ? true : false;
    }


    // 四双
    protected function fourEven()
    {
        if ($this->row->r1 % 2 == 0) {
            if ($this->row->r2 % 2 == 0) {
                if ($this->row->r3 % 2 == 0) {
                    if ($this->row->r4 % 2 == 0) {
                        return true;
                    }
                }
            }
        }
        return  false;
    }
    protected function fourEvenValue($val)
    {
        if ($val == 1) return ($this->row->r1 % 2) ? false : true;
        if ($val == 2) return ($this->row->r2 % 2) ? false : true;
        if ($val == 3) return ($this->row->r3 % 2) ? false : true;
        if ($val == 4) return ($this->row->r4 % 2) ? false : true;
    }


    // 取值
    protected function between($start = 7, $end = 30)
    {
        $sum = $this->row->r1 + $this->row->r2 + $this->row->r3 + $this->row->r4;
        if ($sum >= $start && $sum <= $end) {
            return true;
        } else {
            return false;
        }
    }

    // 检测双双重
    protected function twoDouble()
    {
        $array = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        sort($array);
        if ($array[0] <> $array[1]) return false;
        if ($array[2] <> $array[3]) return false;
        return true;
    }

    // 双重
    protected function twoDoubleOne()
    {
        $array = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        $array = array_unique($array);
        $num = count($array);
        //  echo $num . "<br />";
        if ($num < 4) {
            return true;
        } else {
            return false;
        }
        return $num ? true : false;
    }

    // 检测三重
    protected function threeDouble()
    {
        $vv = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        $n_arr = array_count_values($vv);
        foreach ($n_arr as $k => $v) {
            if ($v >= 3) return true;
        }
        return false;
    }

    // 三数合-返回数组
    protected function threeHeReturn()
    {
        $getValue[] = $this->threeCountValue($this->row->r1, $this->row->r2, $this->row->r3);
        $getValue[] = $this->threeCountValue($this->row->r1, $this->row->r2, $this->row->r4);
        $getValue[] = $this->threeCountValue($this->row->r1, $this->row->r3, $this->row->r4);
        $getValue[] = $this->threeCountValue($this->row->r2, $this->row->r3, $this->row->r4);
        $getValue = array_unique($getValue);
        return $getValue;
    }

    // 三数取模
    protected function threeCountValue($v1, $v2, $v3)
    {
        return ($v1 + $v2 + $v3) % 10;
    }

    // 四数合
    protected function fourSum($arr)
    {
        $sum = ($this->row->r1 + $this->row->r2 + $this->row->r3 + $this->row->r4) % 10;
        $result = in_array($sum, $arr);
        return (in_array($sum, $arr)) ? true : false;
    }

    // 两数取模
    protected function twoCountValue($v1, $v2)
    {
        return ($v1 + $v2) % 10;
    }

    // 上数测试数据
    protected function upNumberReturn()
    {
        return array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
    }

    // 排位值
    protected function exNumber($num, $value)
    {
        // 千位
        if ($num == 1) return ($this->row->r1 == $value) ? true : false;
        // 百位
        if ($num == 2) return ($this->row->r2 == $value) ? true : false;
        // 十位
        if ($num == 3) return ($this->row->r3 == $value) ? true : false;
        // 个位
        if ($num == 4) return ($this->row->r4 == $value) ? true : false;
    }

    // 二数合
    protected function twoHeReturn()
    {
        $getValue[] = $this->twoCountValue($this->row->r1, $this->row->r2);
        $getValue[] = $this->twoCountValue($this->row->r1, $this->row->r3);
        $getValue[] = $this->twoCountValue($this->row->r1, $this->row->r4);

        $getValue[] = $this->twoCountValue($this->row->r2, $this->row->r3);
        $getValue[] = $this->twoCountValue($this->row->r2, $this->row->r4);

        $getValue[] = $this->twoCountValue($this->row->r3, $this->row->r4);

        return array_unique($getValue);
    }

    /*
     * 两兄弟
     *  - 检测千百十个位任意两个数字是否相邻值差一.
     * 
     * @return bool
     */
    protected function twoBroder()
    {
        $arr = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        $result = array_unique($arr);

        // 如果数组为空或只有一个元素，直接返回true
        if (count($result) <= 1) return false;

        $sorted = $result;
        sort($sorted);

        for ($i = 0; $i < count($sorted) - 1; $i++) {
            $current = $sorted[$i];
            $next = $sorted[$i + 1];

            // 正常相邻
            if ($next - $current === 1) return true;

            // 循环相邻：当前是最大值，下一个是最小值
            if ($next == 9 && $sorted[0] == 0) return true;
        }

        return false;
    }

    /*
     * 对数
     */
    protected function doubleNumber()
    {
        $arr = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);

        if (in_array(0, $arr) && in_array(5, $arr)) return true;
        if (in_array(1, $arr) && in_array(6, $arr)) return true;
        if (in_array(2, $arr) && in_array(7, $arr)) return true;
        if (in_array(3, $arr) && in_array(8, $arr)) return true;
        if (in_array(4, $arr) && in_array(9, $arr)) return true;
        return false;
    }
    protected function doubleNumberCale($parm1, $parm2)
    {
        $arr = array($this->row->r1, $this->row->r2, $this->row->r3, $this->row->r4);
        return (in_array($parm1, $arr) && in_array($parm2, $arr)) ? true : false;
    }

    // 四大
    protected function fourBig($val)
    {
        if ($val == 1) return ($this->row->r1 >= 5) ? true : false;
        if ($val == 2) return ($this->row->r2 >= 5) ? true : false;
        if ($val == 3) return ($this->row->r3 >= 5) ? true : false;
        if ($val == 4) return ($this->row->r4 >= 5) ? true : false;
    }

    // 四小
    protected function fourSmall($val)
    {
        if ($val == 1) return ($this->row->r1 < 5) ? true : false;
        if ($val == 2) return ($this->row->r2 < 5) ? true : false;
        if ($val == 3) return ($this->row->r3 < 5) ? true : false;
        if ($val == 4) return ($this->row->r4 < 5) ? true : false;
    }
}

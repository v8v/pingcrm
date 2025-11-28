<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class LotteryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Lottery/Index');
    }

    public function search(Request $request)
    {
        // 每条数据的提示信息
        $messageText = '';
        $noZhongNum = 0;
        $zhongNum = 0;
        $totalNoZhong = [0 => 0];
        $totalZhong = [0 => 0];
        $totalZhongArray = [];
        $zhongSum = 0;  // 中奖总数
        $caleTitle = '';
        $typeSum = array();  //  不同类型统计
        $recordList = array();   // 输出记录列表

        $num = $request->input('cxqs');  //号码

        // 获取限定条数的号码记录
        $result = $this->getResultLimitRecord($num);
        $result = $result->sortBy('number');

        //两数合
        $lshSum = 0;
        $lsh = $request->input('lsh');
        if (!empty($lsh)) {
            $lshArr = str_split($lsh);
        //    $caleTitle .= "两数合：{$lsh}；";
            $lshTitle = "两数合：{$lsh}；";
        }

        //三数合
        $sshSum = 0;
        $ssh = $request->input('ssh');
        if (!empty($ssh)) {
            $sshArr = str_split($ssh);
           $sshTitle = "三数合：{$ssh}；";
            // $caleTitle .= "三数合：{$ssh}；";
        }

        // 全转
        $qzSum = 0;
        $qz = $request->input('qz');
        if (!empty($qz)) {
            $qzArr = str_split($qz);
            $qzTitle = "全转：{$qz}；";
            // $caleTitle .= "全转：{$qz}；";
        }

        // 排除
        $pcSum = 0;
        $pc = $request->input('pc');
        if (!empty($pc)) {
            $pcArr = str_split($pc);
            $qcTitle = "排除：{$pc}；";
            // $caleTitle .= "排除：{$pc}；";
        }

        // 上奖
        $sjSum = 0;
        $sj = $request->input('sj');
        if (!empty($sj)) {
            $sjArr = str_split($sj);
            $sjTitle = "上奖：{$sj}；";
            // $caleTitle .= "上奖：{$sj}；";
        }

        // 取值范围
        $qyzfSum = 0;
        $qzfw = $request->input('qzfw');
        if (!empty($qzfw)) {
            $qzfwTitle = "取值范围：{$qzfw}；";
            // $caleTitle .= "取值范围：{$qzfw}；";
            $qzfwArr = explode('-', $qzfw);
        }

        // 双重
        $shuangchongSum = 0;
        $shuangchong = $request->input('shuangchong');
        if ($shuangchong == '1' || $shuangchong == '2') ($shuangchong == '1') ? $shuangchongTitle = '除双重;' : $shuangchongTitle = '取双重;';

        // 双双重
        $shuangshuangchongSum = 0;
        $shuangshuangchong = $request->input('shuangshuangchong');
        if ($shuangshuangchong == '1' || $shuangshuangchong == '2') ($shuangshuangchong == '1') ? $shuangshuangchongTitle = '除双双重;' : $shuangshuangchongTitle = '取双双重;';


        // 三重
        $sanchongSum = 0;
        $sanchong = $request->input('sanchong');
        if ($sanchong == '1' || $sanchong == '2') ($sanchong == '1') ? $sanchongTitle = '除三重;' : $sanchongTitle = '取三重;';

        // 四重
        $sichongSum = 0;
        $sichong = $request->input('sichong');
        if ($sichong == '1' || $sichong == '2') ($sichong == '1') ? $sichongTitle = '除四重;' : $sichongTitle = '取四重;';

        // 二兄弟
        $erxiongdiSum = 0;
        $erxiongdi = $request->input('erxiongdi');
        if ($erxiongdi == '1' || $erxiongdi == '2') ($erxiongdi == '1') ? $erxiongdiTitle = '除二兄弟;' : $erxiongdiTitle = '取二兄弟;';

        // 三兄弟
        $sanxiongdiSum = 0;
        $sanxiongdi = $request->input('sanxiongdi');
        if ($sanxiongdi == '1' || $sanxiongdi == '2') ($sanxiongdi == '1') ? $sanxiongdiTitle = '除三兄弟;' : $sanxiongdiTitle = '取三兄弟;';

        // 四兄弟
        $sixiongdiSum = 0;
        $sixiongdi = $request->input('sixiongdi');
        if ($sixiongdi == '1' || $sixiongdi == '2') ($sixiongdi == '1') ? $sixiongdiTitle = '除四兄弟;' : $sixiongdiTitle = '取四兄弟;';

        // 对数
        $duishuSum = 0;
        $duishuText = '';
        $duishu = $request->input('duishu');
        $duishuValue = $request->input('duishuValue');
        if ($duishu == '1' || $duishu == '2') {
            foreach ($duishuValue as $key => $value) $duishuText  .= $value . ' ';
            ($duishu == '1') ? $duishuTitle = '除对数' . $duishuText . ';' : $duishuTitle = '取对数' . $duishuText . ';';
        }

        // 单
        $danSum = 0;
        $danText = '';
        $dan = $request->input('dans');
        $danValue = $request->input('dan');
        if ($dan == '1' || $dan == '2') {
            foreach ($danValue as $key => $value) {
                ($value == '1') ? $danText  .= '千' : '';
                ($value == '2') ? $danText  .= '百' : '';
                ($value == '3') ? $danText  .= '十' : '';
                ($value == '4') ? $danText  .= '个' : '';
            }
            ($dan == '1') ? $danTitle = '除单:' . $danText . ';' : $danTitle = '取单:' . $danText . ';';
        }

        // 双
        $shuangSum = 0;
        $shuangText = '';
        $shuang = $request->input('shuangs');
        $shuangValue = $request->input('shuang');
        if ($shuang == '1' || $shuang == '2') {
            foreach ($shuangValue as $key => $value) {
                ($value == '1') ? $shuangText  .= '千' : '';
                ($value == '2') ? $shuangText  .= '百' : '';
                ($value == '3') ? $shuangText  .= '十' : '';
                ($value == '4') ? $shuangText  .= '个' : '';
            }
            ($shuang == '1') ? $shuangTitle = '除双:' . $shuangText . ';' : $shuangTitle = '取双:' . $shuangText . ';';
        }

        // 大
        $daSum = 0;
        $daText = '';
        $da = $request->input('das');
        $daValue = $request->input('da');
        if ($da == '1' || $da == '2') {
            foreach ($daValue as $key => $value) {
                ($value == '1') ? $daText  .= '千' : '';
                ($value == '2') ? $daText  .= '百' : '';
                ($value == '3') ? $daText  .= '十' : '';
                ($value == '4') ? $daText  .= '个' : '';
            }
            ($da == '1') ? $daTitle = '除大:' . $daText . ';' : $daTitle = '取大:' . $daText . ';';
        }

        // 小
        $xiaoSum = 0;
        $xiaoText = '';
        $xiao = $request->input('xiaos');
        $xiaoValue = $request->input('xiao');
        if ($xiao == '1' || $xiao == '2') {
            foreach ($xiaoValue as $key => $value) {
                ($value == '1') ? $xiaoText  .= '千' : '';
                ($value == '2') ? $xiaoText  .= '百' : '';
                ($value == '3') ? $xiaoText  .= '十' : '';
                ($value == '4') ? $xiaoText  .= '个' : '';
            }
            ($xiao == '1') ? $xiaoTitle = '除小:' . $xiaoText . ';' : $xiaoTitle = '取小:' . $xiaoText . ';';
        }





        // 开始循环判断
        foreach ($result as $key => $value) {
            $i = 0;
            $this->row = $value;


            // 两数合
            if (!empty($lsh)) {

                $two = $this->twoHeReturn();
                $twoResult = array_intersect($two, $lshArr);
                if (count($twoResult) == 0) {
                    $i++;
                    $lshSum++;
                    $messageText .= '两数合不符；';
                }
            }

            // 三数合
            if (!empty($ssh)) {

                $sshReturn = $this->threeHe($sshArr);
                if ($sshReturn) {
                    $i++;
                    $sshSum++;
                    $messageText .= '三数合不符；';
                }
            }

            // 全转

            // 排除
            if (!empty($pc)) {
                $pcReturn = $this->upNumber($pcArr);
                if ($pcReturn) {
                    $i++;
                    $pcSum++;
                    $messageText .= "排除不符；";
                }
            }

            // 上奖
            if (!empty($sj)) {
                $sjReturn = $this->upNumber($sjArr);
                if (!$sjReturn) {
                    $i++;
                    $sjSum++;
                    $messageText .= "上奖不符；";
                }
            }

            // 取值范围
            if (!empty($qzfw)) {
                $qzfwReturn = $this->between($qzfwArr[0], $qzfwArr[1]);
                if (!$qzfwReturn) {
                    $i++;
                    $qyzfSum++;
                    $messageText .= "取值范围不符；";
                }
            }

            // 双重
            if ($shuangchong == '1' || $shuangchong == '2') {
                $shuangchongReturn = $this->twoDoubleOne();
                if ($shuangchong == '1' && $shuangchongReturn) {
                    $i++;
                    $shuangchongSum++;
                    $messageText .= "除双重不符；";
                }
                if ($shuangchong == '2' && !$shuangchongReturn) {
                    $i++;
                    $shuangchongSum++;
                    $messageText .= "取双重不符；";
                }
            }

            // 双双重
            if ($shuangshuangchong == '1' || $shuangshuangchong == '2') {
                $shuangshuangchongReturn = $this->twoDouble();
                if ($shuangshuangchong == '1' && $shuangshuangchongReturn) {
                    $i++;
                    $shuangshuangchongSum++;
                    $messageText .= "除双双重不符；";
                }
                if ($shuangshuangchong == '2' && !$shuangshuangchongReturn) {
                    $i++;
                    $shuangshuangchongSum++;
                    $messageText .= "取双双重不符；";
                }
            }

            // 三重
            if ($sanchong == '1' || $sanchong == '2') {
                $sanchongReturn = $this->threeDouble();
                if ($sanchong == '1' && $sanchongReturn) {
                    $i++;
                    $sanchongSum++;
                    $messageText .= "除三重不符；";
                }
                if ($sanchong == '2' && !$sanchongReturn) {
                    $i++;
                    $sanchongSum++;
                    $messageText .= "取三重不符；";
                }
            }

            // 四重
            if ($sichong == '1' || $sichong == '2') {
                $sichongReturn = $this->fourDouble();
                if ($sichong == '1' && $sichongReturn) {
                    $i++;
                    $sichongSum++;
                    $messageText .= "除四重不符；";
                }
                if ($sichong == '2' && !$sichongReturn) {
                    $i++;
                    $sichongSum++;
                    $messageText .= "取四重不符；";
                }
            }

            // 二兄弟
            if ($erxiongdi == '1' || $erxiongdi == '2') {
                $erxiongdiReturn = $this->twoBroder();
                if ($erxiongdi == '1' && $erxiongdiReturn) {
                    $i++;
                    $erxiongdiSum++;
                    $messageText .= "除二兄弟不符；";
                }
                if ($erxiongdi == '2' && !$erxiongdiReturn) {
                    $i++;
                    $erxiongdiSum++;
                    $messageText .= "取二兄弟不符；";
                }
            }

            // 三兄弟
            if ($sanxiongdi == '1' || $sanxiongdi == '2') {
                $sanxiongdiReturn = $this->threeBrother();
                if ($sanxiongdi == '1' && $sanxiongdiReturn) {
                    $i++;
                    $sanxiongdiSum++;
                    $messageText .= "除三兄弟不符；";
                }
                if ($sanxiongdi == '2' && !$sanxiongdiReturn) {
                    $i++;
                    $sanxiongdiSum++;
                    $messageText .= "取三兄弟不符；";
                }
            }

            // 四兄弟
            if ($sixiongdi == '1' || $sixiongdi == '2') {
                $sixiongdiReturn = $this->fourBrother();
                if ($sixiongdi == '1' && $sixiongdiReturn) {
                    $i++;
                    $sixiongdiSum++;
                    $messageText .= "除四兄弟不符；";
                }
                if ($sixiongdi == '2' && !$sixiongdiReturn) {
                    $i++;
                    $sixiongdiSum++;
                    $messageText .= "取四兄弟不符；";
                }
            }

            // 对数
            $duishuCheck = 0;
            $duishuValueText = '';
            if ($duishu == '1') {
                foreach ($duishuValue as $key => $value) {
                    $val = str_split($value);
                    $duishuReturn = $this->doubleNumberCale($val[0], $val[1]);
                    if ($duishuReturn) {
                        $duishuCheck++;
                        $duishuValueText .= $value . ' ';
                    }
                }
                if ($duishuCheck > 0) {
                    $i++;
                    $duishuSum++;
                } 
                $messageText .= "除对数{$duishuValueText}不符；";
            }
            if ($duishu == '2') {
                foreach ($duishuValue as $key => $value) {
                    $val = str_split($value);
                    $duishuReturn = $this->doubleNumberCale($val[0], $val[1]);
                    if (!$duishuReturn) {
                        $duishuCheck++;
                      //  $value .= $value . ' ';
                        $duishuValueText .= $value . ' ';
                    }
                }
                if ($duishuCheck == count($duishuValue)) {
                    $i++;
                    $duishuSum++;
                    $messageText .= "取对数{$duishuValueText}不符；";
                }


                
            }

            // 单
            if ($dan == '1') {
                $val = '';
                foreach ($danValue as $key => $value) {
                    $danReturn = $this->fourSingleValue($value);;
                    if ($danReturn) {
                        $i++;
                        $danSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "除单 " . $val . "不符；";
            }
            if ($dan == '2') {
                $val = '';
                foreach ($danValue as $key => $value) {
                    $danReturn = $this->fourSingleValue($value);;
                    if (!$danReturn) {
                        $i++;
                        $danSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "取单 " . $val . "不符；";
            }

            // 双
            if ($shuang == '1') {
                $val = '';
                foreach ($shuangValue as $key => $value) {
                    $shuangReturn = $this->fourEvenValue($value);;
                    if ($shuangReturn) {
                        $i++;
                        $shuangSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "除双 " . $val . "不符；";
            }
            if ($shuang == '2') {
                $val = '';
                foreach ($shuangValue as $key => $value) {
                    $shuangReturn = $this->fourEvenValue($value);;
                    if (!$shuangReturn) {
                        $i++;
                        $shuangSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "取双 " . $val . "不符；";
            }

            // 大
            if ($da == '1') {
                $val = '';
                foreach ($daValue as $key => $value) {
                    $daReturn = $this->fourBig($value);;
                    if ($daReturn) {
                        $i++;
                        $daSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "除大 " . $val . "不符；";
            }
            if ($da == '2') {
                $val = '';
                foreach ($daValue as $key => $value) {
                    $daReturn = $this->fourBig($value);;
                    if (!$daReturn) {
                        $i++;
                        $daSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "取大 " . $val . "不符；";
            }

            // 小
            if ($xiao == '1') {
                $val = '';
                foreach ($xiaoValue as $key => $value) {
                    $xiaoReturn = $this->fourSmall($value);;
                    if ($xiaoReturn) {
                        $i++;
                        $xiaoSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "除小 " . $val . "不符；";
            }
            if ($xiao == '2') {
                $val = '';
                foreach ($xiaoValue as $key => $value) {
                    $xiaoReturn = $this->fourSmall($value);;
                    if (!$xiaoReturn) {
                        $i++;
                        $xiaoSum++;
                        if ($value == '1') $val .= '千 ';
                        if ($value == '2') $val .= '百 ';
                        if ($value == '3') $val .= '十 ';
                        if ($value == '4') $val .= '个 ';
                    }
                }
                $messageText .= "取小 " . $val . "不符；";
            }






            ($i == 0) ? $totalZhongArray[] = 0 :  $totalZhongArray[] = 1;
            if ($i == 0) $zhongSum++;

            $recordList[] = [
                'number' => $this->row->number,
                'r1' => $this->row->r1,
                'r2' => $this->row->r2,
                'r3' => $this->row->r3,
                'r4' => $this->row->r4,
                'message' => $messageText,
            ];
            // 清空提示信息
            $messageText = '';
        }
        // 对记录列表按号码排序
        array_multisort(array_column($recordList, 'number'), SORT_DESC, $recordList);

        if (!empty($lsh)) $caleTitle .= $lshTitle;
        if (!empty($ssh)) $caleTitle .= $sshTitle;
        if (!empty($qz)) $caleTitle .= $qzTitle;
        if (!empty($pc)) $caleTitle .= $qcTitle;
        if (!empty($sj)) $caleTitle .= $sjTitle;
        if (!empty($qzfw)) $caleTitle .= $qzfwTitle;
        if (!empty($shuangchong)) $caleTitle .= $shuangchongTitle;
        if (!empty($shuangshuangchong)) $caleTitle .= $shuangshuangchongTitle;
        if (!empty($sanchong)) $caleTitle .= $sanchongTitle;
        if (!empty($sichong)) $caleTitle .= $sichongTitle;
        if (!empty($erxiongdi)) $caleTitle .= $erxiongdiTitle;
        if (!empty($sanxiongdi)) $caleTitle .= $sanxiongdiTitle;
        if (!empty($sixiongdi)) $caleTitle .= $sixiongdiTitle;
        if (!empty($duishu)) $caleTitle .= $duishuTitle;
        if (!empty($dan)) $caleTitle .= $danTitle;
        if (!empty($shuang)) $caleTitle .= $shuangTitle;
        if (!empty($da)) $caleTitle .= $daTitle;
        if (!empty($xiao)) $caleTitle .= $xiaoTitle;

        if (!empty($lshSum)) $typeSum['lshSum'] = [$lshSum, $lshTitle];
        if (!empty($sshSum)) $typeSum['sshSum'] = [$sshSum, $sshTitle];
        if (!empty($pcSum)) $typeSum['pcSum'] = [$pcSum, $qcTitle];
        if (!empty($sjSum)) $typeSum['sjSum'] = [$sjSum, $sjTitle];
        if (!empty($qyzfSum)) $typeSum['qyzfSum'] = [$qyzfSum, $qzfwTitle];
        if (!empty($shuangchongSum)) $typeSum['shuangchongSum'] = [$shuangchongSum, $shuangchongTitle];
        if (!empty($shuangshuangchongSum)) $typeSum['shuangshuangchongSum'] = [$shuangshuangchongSum, $shuangshuangchongTitle];
        if (!empty($sanchongSum)) $typeSum['sanchongSum'] = [$sanchongSum, $sanchongTitle];
        if (!empty($sichongSum)) $typeSum['sichongSum'] = [$sichongSum, $sichongTitle];
        if (!empty($erxiongdiSum)) $typeSum['erxiongdiSum'] = [$erxiongdiSum, $erxiongdiTitle];
        if (!empty($sanxiongdiSum)) $typeSum['sanxiongdiSum'] = [$sanxiongdiSum, $sanxiongdiTitle];
        if (!empty($sixiongdiSum)) $typeSum['sixiongdiSum'] = [$sixiongdiSum, $sixiongdiTitle];
        if (!empty($duishuSum)) $typeSum['duishuSum'] = [$duishuSum, $duishuTitle];
        if (!empty($danSum)) $typeSum['danSum'] = [$danSum, $danTitle];
        if (!empty($shuangSum)) $typeSum['shuangSum'] = [$shuangSum, $shuangTitle];
        if (!empty($daSum)) $typeSum['daSum'] = [$daSum, $daTitle];
        if (!empty($xiaoSum)) $typeSum['xiaoSum'] = [$xiaoSum, $xiaoTitle];

        // 统计总的不中和中的次数
        $totalZhong = $this->countConsecutiveUniversal($totalZhongArray);

        // var_dump($total);
        // var_dump($totalZhong);
        return Inertia::render('Lottery/Result', [
            'caleTitle' => $caleTitle,
            'contact' => 'aa',
            'noZhongNum' => $totalZhong,
            'zhongNum' => $totalZhong,
            'number' => $num,
            'searchSum' => $zhongSum,
            'zhongSum' => $zhongSum,
            'typeSum' => $typeSum,
            'recordList' => $recordList,
        ]);
    }

    // public function test()
    // {
    //     DB::table('lotteryResult')->get();
    //     echo "test";
    // }


    /**
     * 通用版本 - 统计数组中各值连续出现的次数
     * 输出格式为 array(值 => array(连续长度 => 出现次数))
     * 
     * @param array $array 要统计的数组
     * @return array 返回统计结果
     */
    public function countConsecutiveUniversal(array $array): array
    {
        if (empty($array)) {
            return [];
        }

        $result = [];
        $currentValue = $array[0];
        $currentCount = 1;

        // 遍历数组
        for ($i = 1; $i < count($array); $i++) {
            if ($array[$i] === $currentValue) {
                $currentCount++;
            } else {
                // 记录当前连续段
                if (!isset($result[$currentValue][$currentCount])) {
                    $result[$currentValue][$currentCount] = 0;
                }
                $result[$currentValue][$currentCount]++;

                // 重置计数
                $currentValue = $array[$i];
                $currentCount = 1;
            }
        }

        // 处理最后一个连续段
        if (!isset($result[$currentValue][$currentCount])) {
            $result[$currentValue][$currentCount] = 0;
        }
        $result[$currentValue][$currentCount]++;

        return $result;
    }


    //
}

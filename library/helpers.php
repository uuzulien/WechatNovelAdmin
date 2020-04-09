<?php
/**
 * Created by PhpStorm.
 * User: Feelop
 * Date: 2017/7/18
 * Time: 14:47
 */

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use function foo\func;

function rand4()
{
    return rand(1000, 9999);
}

function rand6()
{
    return rand(100000, 999999);
}

function humpToLine($str)
{
    $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
        return '_' . strtolower($matches[0]);
    }, $str);

    return $str;
}

function lineToHump($str)
{
    $str = preg_replace_callback('/_([a-z]{1})/', function ($matches) {
        return strtoupper($matches[1]);
    }, $str);

    return $str;
}

function return_bank_code($bank_name)
{
    $bank = [
        "中国工商银行" => "ICBC",
        "中国农业银行" => "ABC",
        "中国建设银行" => "CCB",
        "中国银行" => "BOC",
        "中国交通银行" => "BCOM",
        "交通银行" => "BCOM",
        "兴业银行" => "CIB",
        "中信银行" => "CITIC",
        "中国光大银行" => "CEB",
        "平安银行" => "PAB",
        "中国邮政储蓄银行" => "PSBC",
        "上海银行" => "SHB",
        "浦东发展银行" => "SPDB",
        "上海浦东发展银行" => "SPDB",
        "民生银行" => "CMBC",
        "中国民生银行" => "CMBC",
        "广发银行" => "GDB",
    ];

    return isset($bank[$bank_name]) ? $bank[$bank_name] : '';
}

/**
 * 错误提示
 *
 * @param string $msg
 * @param int $code
 * @param int $httpStatus
 *
 * @return \Illuminate\Http\JsonResponse
 */
function error($msg = '未知错误', $code = 0, $httpStatus = 422)
{
    return response()->json(['message' => $msg, 'code' => $code, 'data' => ''], $httpStatus);
}

/**
 * 成功提示
 *
 * @param array $data
 * @param string $dataName
 *
 * @return \Illuminate\Http\JsonResponse
 */
function success($data = [], $dataName = 'data', $message = 'success')
{
    return response()->json(['message' => $message, 'code' => 1, "{$dataName}" => $data], 200);
}

function diffDays($begin_date, $end_date = null)
{
    $b = new Carbon($begin_date);
    $e = $end_date ? new Carbon($end_date) : Carbon::today();

    return $b->diffInDays($e, false);
}

function mobileLastNumber($mobile)
{
    return substr($mobile, -4);
}

function mobileThreeNumber($mobile)
{
    return substr($mobile, 0, 3);
}

function bankCardLastNumber($bankCard)
{
    return substr($bankCard, -4);
}

function bankCardThreeNumber($bankCard)
{
    return substr($bankCard, 0, 3);
}

function idCardThreeNumber($idCard)
{
    return substr($idCard, 0, 3);
}

function idCardLastNumber($idCard)
{
    return substr($idCard, -4);
}

function hiddenBankCardNumber($bankCard)
{
    return substr($bankCard, 0, 3) . str_pad('', strlen($bankCard) - 7, '*') . substr($bankCard, -4);
}

function hiddenIDCardNumber($idcard)
{
    return substr($idcard, 0, 3) . str_pad('', strlen($idcard) - 7, '*') . substr($idcard, -4);
}

function hiddenMobileNumber($mobile)
{
    return substr($mobile, 0, -11) . substr($mobile, -11, -8) . str_pad('', 4, '*') . substr($mobile, -4);
}

function hiddenName($name)
{
    $lenghtName = mb_strlen($name);
    if ($lenghtName < 3) {
        return '*' . mb_substr($name, -1);
    }
    return '**' . mb_substr($name, -1);
}

function decodeName($name)
{
    $lenghtName = strlen($name);
    switch ($lenghtName) {
        case 1:
            return $name;
            break;
        case 2:
            $twoName = substr($name, -1);

            return $twoName;
            break;

        case 3:
            $threeName = substr($name, -2);

            return $threeName;
            break;

        default:
            $otherName = substr($name, -2);

            return $otherName;
            break;
    }
}


function getCapitalName($capital = null)
{
    if ($capital === 0 || $capital === '0') {
        return '享车';
    }
    $name = Cache::get('capital:name:' . $capital, function () use ($capital) {
        $data = \App\Models\Capital::find($capital);
        $name = isset($data->capital_name) ? $data->capital_name : '';
        if ($data && isset($data->capital_name)) {
            Cache::forever('capital:name:' . $capital, $data->capital_name);
        }

        return $name;
    });
    return $name;
}

function getPackageName($package = null)
{
    if ($package === 0 || $package === '0') {
        return '享车';
    }
    $name = Cache::get('package:name:' . $package, function () use ($package) {
        $data = \App\Models\Capital::find($package);
        $name = isset($data->package_name) ? $data->package_name : '';
        if ($data && isset($data->package_name)) {
            Cache::forever('package:name:' . $package, $data->package_name);
        }

        return $name;
    });
    return $name;
}

/*
 * 请求同盾第三方接口
 */
function todo_push($url, $params = false, $ispost = 0)
{
    $httpInfo = array();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Ucar');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
        echo curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    return $response;
}

/*
 * 此函数用于从鹏元那边获取wsdl数据 并且写入wsdl文件 此文件为用于
 * 通信请求征信数据的必要条件
 * @return wsdl文件的path
 */
function getWsdlFilePath($password, $pengyuanUrl, $certificatePath)
{
    $urlForGetwsdl = $pengyuanUrl . '/services/WebServiceSingleQuery?wsdl';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlForGetwsdl);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 不检查证书中域名
    curl_setopt($ch, CURLOPT_VERBOSE, '1'); //开发模式，会把通信时的信息显示出来
    curl_setopt($ch, CURLOPT_SSLCERT, $certificatePath . '/yknfnys.cer');  //pem
    curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $password);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSLKEY, $certificatePath . '/yknfnys.key');  //key
    curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $password);
    curl_setopt($ch, CURLOPT_POST, false); //不能用POST
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($ch);
    if ($resp == false) {
        echo(curl_error($ch));
    };
    curl_close($ch);
    $wsdlPath = storage_path('wsdl/') . 'pycredit.wsdl';
    $fp = fopen($wsdlPath, 'w');//把结果写入wsdl文件
    fwrite($fp, $resp);
    fclose($fp);

    return $wsdlPath;
}

/*
* 成功或者失败的提示
*/
function flash_message($message = '成功', $success = true)
{
    $className = $success ? 'alert-success' : 'alert-danger';
    session()->flash('alert-message', $message);
    session()->flash('alert-class', $className);
}

function addDay($time, $day)
{
    return (new Carbon($time))->addDay($day)->toDateString();
}

function generateRandomString($length = 18)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function pushToUserIdentifier($user_id)
{
    $user = \App\Models\Users::find($user_id) ?? null;
    $to = [
        "user_id" => $user->id ?? null,        //必要参数,必须为整数
        "mobile" => $user->mobile ?? null,
        "registration_id" => $user->info->registration_id ?? null,
        "wechat_open_id" => \App\Models\UserWechat::where('user_id', $user_id)->value('open_id') ?? null,
    ];

    return $to;
}

if (!function_exists('is_route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string $name
     * @return bool
     */
    function is_route($name)
    {
        try {
            route($name);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

function getName($id)
{
    return \App\Models\AdminUsers::find($id)->name ?? null;
}

function getDiffDay($day1, $day2)
{
    $Date_1 = Carbon::parse($day1)->toDateString();
    $Date_2 = Carbon::parse($day2)->toDateString();
    $d1 = strtotime($Date_1);
    $d2 = strtotime($Date_2);
    return round(($d2 - $d1) / 3600 / 24);
}

/**
 * 将分转为元
 * @param $amount
 * @return string
 */
function moneyConvert($amount)
{
    switch (strlen($amount)) {
        case 1:
            $amount = '0.0' . $amount;
            break;
        case 2:
            $amount = '0.' . $amount;
            break;
        default:
            $amount = substr($amount, 0, -2) . '.' . substr($amount, -2);
            break;
    }
    return $amount;
}

function getPayStatus($status)
{
    switch ($status) {
        case 0:
            $status = '预处理';
            break;
        case 1:
            $status = '等待支付';
            break;
        case 2:
            $status = '支付中';
            break;
        case 3:
            $status = '支付完成';
            break;
        case 4:
            $status = '支付失败';
            break;
        case 5:
            $status = '申请退款';
            break;
        case 6:
            $status = '退款中';
            break;
        case 7:
            $status = '退款完成';
            break;
        case 8:
            $status = '8订单取消';
            break;
    }

    return $status;
}
function getChannel($channel)
{
    switch ($channel) {
        case 1:
            $status = '宝付划扣';
            break;
        case 2:
            $status = '宝付认证';
            break;
        case 3:
            $status = '宝付快捷';
            break;
        case 4:
            $status = '余额支付';
            break;
        case 5:
            $status = '宝付协议划扣';
            break;
        case 6:
            $status = '宝付协议支付';
            break;
        case 7:
            $status = '划扣免息';
            break;
        case 8:
            $status = '中关村划扣';
            break;
        case 9:
            $status = '线下还款';
            break;
        case 10:
            $status = '线下还款免滞纳金';
            break;
        case 11:
            $status = '滞纳金对冲';
            break;
        case 12:
            $status = '中关村支付';
            break;
        case 13:
            $status = '优惠券支付';
            break;
        case 14:
            $status = '滞纳金退款';
            break;
        case 15:
            $status = '海融易支付';
            break;
        case 16:
            $status = '海融易划扣';
            break;
        case 17:
            $status = '易宝协议支付';
            break;
        case 18:
            $status = '易宝划扣';
            break;
        case 19:
            $status = '有利支付';
            break;
        case 20:
            $status = '保证金抵扣';
            break;
        case 21:
            $status = '有利网划扣';
            break;
        case 22:
            $status = '通联支付';
            break;
        case 23:
            $status = '通联划扣';
            break;
        case 24:
            $status = '国银盛达支付';
            break;
        case 25:
            $status = '国银盛达划扣';
            break;
        case 26:
            $status = '永达金融支付';
            break;
        case 27:
            $status = '永达金融划扣';
            break;
        default:
            $status = '其他新渠道';
    }

    return $status;
}
function getApplyInfo($userId)
{

    return \App\Models\IouApply::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->first();
}
function repaymentApplyInfo($userId)
{

    return \App\Models\IouApply::where('user_id', $userId)
        ->where('repayment_cycle', '>',0)
        ->orderBy('created_at', 'desc')
        ->first();
}
function getBankInfo($bankcard)
{
    return \Illuminate\Support\Facades\DB::connection('public')->table('bankcard_bin_bf')->whereRaw("left($bankcard, `bin_length`) = `bin` and length($bankcard) = `length` and `card_type`=1")->first();
}

function getBankName($bankcard)
{
    return \Illuminate\Support\Facades\DB::connection('public')->table('bankcard_bin_bf')->whereRaw("left($bankcard, `bin_length`) = `bin` and length($bankcard) = `length`")->value('bank_name');
}

function array_build($array, Closure $callback)
{
    $results = array();
    foreach ($array as $key => $value)
    {
        list($innerKey, $innerValue) = call_user_func($callback, $key, $value);
        $results[$innerKey] = $innerValue;
    }
    return $results;
}

/**
 * 批量更新
 * @param $table    string      表名
 * @param $data     array       要更新的数据
 * @param $keys     array       保证数据唯一的建
 * @param $wkey     string      确认更新范围的key
 * @return bool
 */
function batchUpdate($table, $data, $keys, $wkey, $connect)
{
    if(empty($data) || !is_array($data[0])){
        \Illuminate\Support\Facades\Log::error('无数据');
        return false;
    }

    //获取所有键的值
    $indexes = array_keys($data[0]);

    //拼接sql
    $sql = "update `$table` set ";

    //when 拼接
    $when = array();
    foreach($indexes as $index){
        if(in_array($index, $keys))
            continue;
        $tmp = "`$index` = CASE ";
        foreach($data as $item){
            $a = array();
            foreach($keys as $key){
                $tmp_key = $item[$key];
                $a[] = "`$key`='$tmp_key'";
            }
            $a = join(' and ', $a);
            $tmp_val = $item[$index];
            $tmp .= " when $a then '$tmp_val'";
        }
        $tmp .= ' end';
        $when[] = $tmp;
    }
    $sql .= join(',' , $when);

    //所有要修改的id
    $where = array();
    foreach ($data as $item){
        $where[] = $item[$wkey];
    }
    $where = "'". join("','", $where). "'";

    //执行
    $sql .= " where `$wkey` in ($where)";
    return \Illuminate\Support\Facades\DB::connection($connect)->update($sql);
}
/**
 * @param $initiator 发起者:1为管理员,2为代理商
 * @param $initiator_id 发起者id
 * @param $action 行为:1为冻结,2为解冻,3为修改密码,4为修改提现金额
 * @param $direction_id 行为针对的代理商id
 * @param $behavior 执行操作的json
 */
function insertAgentManipulateLog($initiator, $initiator_id, $action, $direction_id, $behavior){
    $log = new \App\Models\Agent\AgentManipulateLog;
    $log->initiator = $initiator;
    $log->initiator_id = $initiator_id;
    $log->action = $action;
    $log->direction_id = $direction_id;
    $log->behavior = $behavior;
    $log->save();
}

function getAgeByID($id)
{

//过了这年的生日才算多了1周岁
    if (empty($id)) return '';
    $date = strtotime(substr($id, 6, 8));
//获得出生年月日的时间戳
    $today = strtotime('today');
//获得今日的时间戳 111cn.net
    $diff = floor(($today - $date) / 86400 / 365);
//得到两个日期相差的大体年数

//strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
    $age = strtotime(substr($id, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;

    return $age;
}

function agentStatusBool($time, $code)
{
    $agent = new \App\Models\Agent\AgentChangeStatus();
    return $agent->judgmentTime($time, $code);
}


//处理对象
function dataProcess($data)
{
    return json_decode(json_encode($data), true);
}

//业绩
function calculateMoney($money)
{
    if ($money) {
        return $money / 100;
    }
    return 0;
}

function subTime($time, $str)
{
    if ($time) {
        $arr = explode($str, $time);
        return $arr[0];
    }
}

//代理商下1级正常人数统计
function getAgentNum($data)
{
    if (count($data)) {
        $agentId = [];
        foreach ($data as $item) {
            array_push($agentId, $item->user_id);
        }
        $num = \App\Models\Agent\EnjoyAgentUser::whereIn('id', $agentId)->where('status', 1)->count();
        return $num;
    }
    return 0;
}

//下级代理商列表
function getLowerLevelUserId($userId)
{
    $users = [$userId];
    $second_level = \App\Models\Agent\EnjoyAgentRelation::where('parent_id', $userId)->pluck('user_id')->toArray();
    if ($second_level) {
        $users = array_merge($users,$second_level);
        $third_level = \App\Models\Agent\EnjoyAgentRelation::whereIn('parent_id', $second_level)->pluck('user_id')->toArray();
        if ($third_level) {
            $users = array_merge($users,$third_level);
        }
    }
    return $users;
}

//下级代理商列表
function getLowerLevelCode($userId)
{
    $users = getLowerLevelUserId($userId);
    $second_level = \App\Models\Agent\EnjoyAgentInfo::whereIn('user_id', $users)->pluck('code')->toArray();
    return $second_level;
}

//代理商佣金系数转换
function getAgentCoefficient($json)
{
    if ($json) {
        $arr = json_decode($json);
        $str = '';
        $base = 0;
        foreach ($arr as $val) {
            $str .= $val->level.'<=>'.$base.'-'.$val->amount.', ';
            $base = $val->amount;
        }
        return $str;
    }
    return '';
}

function chargeTypeName($charge_type){
    switch ($charge_type){
        case 1:
            return '中石化';
        case 2:
            return '中石油';
        case 3:
            return 'BP油卡';
        case 5:
            return '闪付联盟卡';
        default:
            return '油卡类型错误';
    }

}

function checkAdvData($data, $str, $id)
{
    if ($data) {
        if ($data[$str] == $id ) {
            return 'selected';
        }
    }
    return false;

}

function checkAdvObjData($data, $str, $id)
{
    if ($data) {
        if ($data[$str] == $id ) {
            return 'checked';
        }
    }
    return false;

}

// 获取本周起始至结束时间
function getCurrentWeek($status)
{
    //当前日期
    $sdefaultDate = date("Y-m-d");
    //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
    $first = 1;
    //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
    $w = date('w', strtotime($sdefaultDate));
    // 获取本周开始日期，如果$w是0，则表示周日，减去 6 天
    $start_time = date('Y-m-d', strtotime("$sdefaultDate -" . ($w ? $w - $first : 6) . ' days'));
    // 本周结束日期
    $end_time = date('Y-m-d', strtotime("$start_time +6 days"));

    if ($status == 'start') {
        return $start_time;
    }
    if ($status == 'end') {
        return $end_time;
    }
}

function getAreaName($areaId){
    return \App\Models\Area::query()->where('id',$areaId)->value('wholeName');
}

function getrandstr(){
    $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr = str_shuffle($str);//打乱字符串
    $rands= substr($randStr,0,6);//substr(string,start,length);返回字符串的一部分
    return $rands;
}

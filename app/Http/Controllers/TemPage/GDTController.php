<?php


namespace App\Http\Controllers\TemPage;


use App\Http\Controllers\Controller;
use App\Repositories\AdminHandleLog\AdminLogHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Gdt\GdtFunc;

class GDTController extends Controller
{
    // 广点通首页
    public function index()
    {
        $list = DB::connection('admin')->table('gdt_template as gt')->leftJoin('page_template as pt', function ($q) {
            $q->on('gt.page_id', '=', 'pt.id');
        })->select(['gt.*','pt.title'])->paginate(15);

        $pages = DB::connection('admin')->table('page_template')->pluck('title','id');

        return view('temPage.list', compact('list','pages'));
    }
    // 模版配置页面
    public function template()
    {
        $list = DB::connection('admin')->table('page_template')->paginate(15);

        return view('temPage.config', compact('list'));
    }
    // 添加广点通模板页面
    public function addTemp(Request $request)
    {
        try {
            $param = $request->all();
            if (empty($param['_token']))
                abort('非法请求！');

            if ($param['content'] == "") {
                $validatorError = ['name' => '请输入本次二跳页面内容'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }

            $id = $param['id'] ?? null;

            $data = [
                'title' => $param['title'],
                'content' => $param['content'],
                'msg' => $param['msg'],
            ];

            DB::connection('admin')->table('page_template')->updateOrInsert(array('id' => $id), $data);


            flash_message('操作成功');
            return redirect()->back();

        }catch (\Exception $e){
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect()->back()
                ->withErrors($error)
                ->withInput();

        }

    }

    // 添加广点通页面
    public function addPage(Request $request)
    {
        try {
            $param = $request->all();
            if (empty($param['_token']))
                abort('非法请求！');

            if ($param['wid'] == "") {
                $validatorError = ['name' => '请输入本页面的id'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }

            $wid = $param['wid'] ?? null;
            $id = $param['id'] ?? null;

            $url = 'http://po.5dan.com/vv/show_b/' . $wid;

            $data = [
                'wechatnamecn' => $param['wechatnamecn'],
                'wechatnameen' => $param['wechatnameen'],
                'page_id' => $param['page_id'],
                'wid' => $wid,
                'href' => $url,
                'msg' => $param['msg'],
            ];

            DB::connection('admin')->table('gdt_template')->updateOrInsert(array('id' => $id), $data);


            flash_message('操作成功');
            return redirect()->back();

        }catch (\Exception $e){
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect()->back()
                ->withErrors($error)
                ->withInput();

        }
    }

    // 广点通页面删除
    public function deletePage($id)
    {
        $page = DB::connection('admin')->table('page_template')->where('id',$id);
        $page->delete();
        AdminLogHandle::write();

        return success('删除成功');
    }

    public function show($id)
    {
        return view('temPage.index');
    }

    // 二跳页面
    public function show_b($id)
    {
        $datas = DB::connection('admin')->table('gdt_template')->where('wid',$id)->first();

        $clickId = request()->input('clickId');
        $data = (new GdtFunc())->user_actions_add($clickId); // 腾讯广告回传
        $library = [
            [
                'name' => $datas->wechatnamecn ?? abort('404'),
                'wechat_key' => $datas->wechatnameen ?? abort('404'),
                'current_key' => '',
                'mpext' => '[]',
                'rands' => '{"r1":"赵 钱 孙 李 周 吴 郑 王 冯 陈 褚 卫 蒋 沈 韩 杨 朱 秦 尤 许 何 吕 施 张 孔 曹 严 华 金 魏 陶 姜 戚 谢 邹 喻 柏 水 窦 章 云 苏 潘 葛 奚 范 彭 郎 鲁 韦 昌 马 苗 凤 花 方 俞 任 袁 柳 酆 鲍 史 唐 费 廉 岑 薛 雷 贺 倪 汤 滕 殷 罗 毕 郝 邬 安 常 乐 于 时 傅 皮 卞 齐 康 伍 余 元 卜 顾 孟 平 黄 和 穆 萧 尹 姚 邵 湛 汪 祁 毛 禹 狄 米 贝 明 臧",
                        "r2":"计 伏 成 戴 谈 宋 茅 庞 熊 纪 舒 屈 项 祝 董 梁 杜 阮 蓝 闵 席 季 麻 强 贾 路 娄 危 江 童 颜 郭 梅 盛 林 刁 钟 徐 邱 骆 高 夏 蔡 田 樊 胡 凌 霍 虞 万 支 柯 昝 管 卢 莫 经 房 裘 缪 干 解 应 宗 丁 宣 贲 邓 郁 单 杭 洪 包 诸 左 石 崔 吉 钮 龚 程 嵇 邢 滑 裴 陆 荣 翁 荀 羊 於 惠 甄 曲 家 封 芮 羿 储 靳 汲 邴 糜 松 井 段 富 巫 乌 焦 巴 弓 牧 隗 山 谷 车 侯 宓 蓬",
                        "r3":"全 郗 班 仰 秋 仲 伊 宫 宁 仇 栾 暴 甘 钭 厉 戎 祖 武 符 刘 景 詹 束 龙 叶 幸 司 韶 郜 黎 蓟 薄 印 宿 白 怀 蒲 邰 从 鄂 索 咸 籍 赖 卓 蔺 屠 蒙 池 乔 阴 鬱 胥 能 苍 双 闻 莘 党 翟 谭 贡 劳 逄 姬 申 扶 堵 冉 宰 郦 雍 卻 璩 桑 桂 濮 牛 寿 通 边 扈 燕 冀 郏 浦 尚 农 温 别 庄 晏 柴 瞿 阎 充 慕 连 茹 习 宦 艾 鱼 容",
                        "r4":"向 古 易 慎 戈 廖 庾 终 暨 居 衡 步 都 耿 满 弘 匡 国 文 寇 广 禄 阙 东 欧 殳 沃 利 蔚 越 夔 隆 师 巩 厍 聂 晁 勾 敖 融 冷 訾 辛 阚 那 简 饶 空 曾 毋 沙 乜 养 鞠 须 丰 巢 关 蒯 相 查 后 荆 红 游 竺 权 逯 盖 益 桓 公 万 俟 司 马 上 官 欧 阳 夏 侯 诸 葛 闻 人 东 方 赫 连 皇 甫 尉 迟 公 羊 澹 台 公 冶 宗 政 濮 阳"
                        }',
            ],
        ];
        if ($clickId) {
            if ($data->code != 0) {
                AdminLogHandle::write('上报失败..');
            }
            AdminLogHandle::write($clickId);
        }

        return view('temPage.show_b', compact('library'));
    }

    public function test()
    {
        dd(time());
        $access_token = config('gdt.default.access_token');
        $data = (new GdtFunc())->user_action_sets_add($access_token);

//            header('content-type:text/html; charset=utf-8');//防止生成的页面乱码
//            $title = '皇后'; //定义变量
//            $temp_file = "temPage/index.html"; //临时文件，也可以是模板文件
//            $dest_file = "assets/uploads/$wid.html"; //生成的目标页面
//
//            $fp = fopen($temp_file, "r"); //只读打开模板
//            $str = fread($fp, filesize($temp_file));//读取模板中内容
//
//            $str = str_replace("{penglig_site_title}", $title, $str);//替换内容
//            $str = str_replace("{penglig_site_content}", $param['content'], $str);//替换内容
//            fclose($fp);
//
//            $handle = fopen($dest_file, "w"); //写入方式打开需要写入的文件
//            fwrite($handle, $str); //把刚才替换的内容写进生成的HTML文件
//            fclose($handle);//关闭打开的文件，释放文件指针和相关的缓冲区
//
//            $url = "http://admin.weijuli8.com/$dest_file";
        return $data;
    }
}

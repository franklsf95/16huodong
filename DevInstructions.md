# 程序架构 #
使用CodeIgniter（http://codeigniter.com/user_guide ）的MVC架构，其中model层由于上一代程序员的个人偏好基本残废。

URL路由为index.php/class/function/param1/param2/param3

| /application | 所有应用程序代码在这里 |
|:-------------|:----------------------------------|
| ./controllers | 所有控制器核心内容在此。除@deprecated外所有类继承自BaseController；用于控制站内显示的类继承自BaseActionController |
| ./controllers/admin | 目前处于不能用状态 |
| ./libraries/extend\_control.php | 反正上一个程序员是把绝大部分数据库存取写在这里了…… |
| ./config/ | 一些程序设置参数在此（主要是config.php和database.php）|
| (Note) | 页面显示通过BaseController::display函数，见inline documentation |

# 前端架构 #
使用Smarty模板（/inc/Smarty）。所有页面调用/application/views/common/base\_template.tpl。BaseController和BaseActionController调用相应的navbar和sidebar。每个页面可以加载自己的CSS和JS（BaseController::display的第三个和第四个参数）。
| /application/views/(ApplicationFolder)/ | 每个controller的模板文件夹；命名格式基本为(function\_name).tpl，(function\_name)_css.tpl，(function\_name)_js.tpl |
|:----------------------------------------|:------------------------------------------------------------------------------------------------------------------------------------|
| /application/views/common/ | 一些通用模板储存在此 |
| /asset/ | 静态资源文件在这里。其实/application/views/images/里还有一些上一个版本UI的素材 |
| /favicon.ico | As what it is. |
| /inc/kindeditor | 前端的richtext editor |
| /upload/(member\_id)/ | 每个用户的上传文件路径 |

# 建议 #
  * 尽量不要修改/system框架内的内容
  * 使用CodeIgniter类库
  * 对于略微复杂的函数请按phpdoc格式在函数前撰写文档
  * Be **BOLD**!
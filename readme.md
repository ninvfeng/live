# live php 简洁高效的PHP框架
## 框架核心只做了一件事: url地址到控制器方法的映射 支持多级控制器目录
- 默认地址:/index/index 对应 app/controller/index.php控制器 index方法
- /admin/user/list 对应 app/controller/admin/user.php控制器 list方法
- /home/user/index/userinfo 对应 app/controller/home/user/index.php控制器 userinfo方法

## 集成mysql操作
[ninvfeng/mysql](https://github.com/ninvfeng/mysql)

## 集成mongodb操作
[ninvfeng/mongodb](https://github.com/ninvfeng/mongodb)

## 集成数据验证
[think-validate](https://github.com/top-think/think-validate)

## 封装get和post方法快速获取并验证请求参数
- $id=get('id','require','请输入ID');
- $username=post('username','require|min:6','请填写用户名且长度不少于6位');

## 适用场景
- 回归php简单的本质, 快速开始一个简单的项目
- 框架核心只有短短几十行, 特别适合学习如何快速搭建一个自己的框架

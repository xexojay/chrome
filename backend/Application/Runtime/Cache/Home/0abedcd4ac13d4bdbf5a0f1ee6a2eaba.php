<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>register</title>
    <link rel="stylesheet" href="/Public/css/foundation.css" />
    <script src="/Public/js/vendor/modernizr.js"></script>
</head>
<body>
<div class="row">
    <div class="large-12 columns">
        <h1 style="text-align:center;">独立说留学资讯memo-注册账号</h1>
    </div>
</div>
<div class="row">
    <form data-abide  action="/index.php/ceshi/register_commit" method="post">
        <div class="name-field">
            <label>用户名<small>必填</small>
                <input type="text" name="name" required pattern="[a-zA-Z]+">
            </label>
            <small class="error">用户名不能为空</small>
        </div>
        <div class="password-field">
            <label>密码 <small>必填</small>
                <input type="password" name="password" id="password" required pattern="[a-zA-Z]+">
            </label>
            <small class="error">密码不能为空</small>
        </div>
        <div class="password-confirmation-field">
            <label>确定密码<small>必填</small>
                <input type="password" required pattern="[a-zA-Z]+" data-equalto="password">
            </label>
            <small class="error">密码要一致</small>
        </div>
        <div class="email-field">
            <label>邮箱<small>必填</small>
                <input type="email" required name="email">
            </label>
            <small class="error">请填写正确的邮箱格式</small>
        </div>
        <button type="submit">提交</button>
    </form>
</div>



<script src="/Public/js/vendor/jquery.js"></script>
<script src="/Public/js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>
<form action="{base_url}user/login" method="post" class="form">
    שם משתמש: <input type="text" name="username" value="<?= set_value('username') ?>"><br>
    סיסמא: <input type="password" name="password" value="<?= set_value('password') ?>"><br>
    <input type="submit" value="התחבר">
    <div class="{message_class}">{message}</div>
</form><br>
<a href="{base_url}user/register" class='link_button'>הרשם</a>
<a href="{base_url}user/forgot_pass" class='link_button'>שכחתי סיסמא</a>
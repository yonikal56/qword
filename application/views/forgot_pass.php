<form action="{base_url}user/forgot_pass" method="post" class="form">
    שם משתמש: <input type="text" name="username" value="<?= set_value('username') ?>"><br>
    <input type="submit" value="שלח סיסמא חדשה">
    <div class="{message_class}">{message}</div>
</form><br>
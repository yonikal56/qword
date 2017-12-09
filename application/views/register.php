<form action="{base_url}user/register" method="post" class="form">
    שם משתמש:<span class="red">*</span><input type="text" name="username" value="<?= set_value('username') ?>"><br>
    סיסמא:<span class="red">*</span><input type="password" name="password" value="<?= set_value('password') ?>"><br>
    אימייל:<span class="red">*</span><input type="email" name="email" value="<?= set_value('email') ?>"><br>
    שם פרטי:<input type="text" name="fname" value="<?= set_value('fname') ?>"><br>
    שם משפחה:<input type="text" name="lname" value="<?= set_value('lname') ?>"><br>
    מין:<select name="gender">
        <option value="0">בחר מין</option>
        <option value="1">זכר</option>
        <option value="2">נקבה</option>
        <option value="3">אחר</option>
    </select><br>
    גיל:<input type="number" name="age" value="<?= set_value('age') ?>"><br>
    עיר:<input type="text" name="city" value="<?= set_value('city') ?>"><br>
    כתובת:<input type="text" name="address" value="<?= set_value('address') ?>"><br>
    טלפון:<input type="text" name="phone" value="<?= set_value('phone') ?>"><br>
    <input type="checkbox" <?= isset($_POST['mailList']) ? 'checked' : ''  ?> name="mailList">הרשם לרשימת התפוצה<br>
    <input type="submit" value="הרשם">
    <div class="{message_class}">{message}</div>
</form>
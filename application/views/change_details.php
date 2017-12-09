{user}
<form action="{base_url}user/change" method="post" class="form">
    סיסמא נוחכית:<span class="red">*</span><input type="password" name="password" value="<?= set_value('password') ?>"><br>
    סיסמא חדשה:<input type="password" name="new_password" value="<?= set_value('new_password') ?>"><br>
    אימייל:<span class="red">*</span><input type="email" name="email" value="<?= set_value('email', '{Email}') ?>"><br>
    שם פרטי:<input type="text" name="fname" value="<?= set_value('fname', '{fName}') ?>"><br>
    שם משפחה:<input type="text" name="lname" value="<?= set_value('lname', '{lName}') ?>"><br>
    מין:<select name="gender">
        <option value="0" id="gender_0 gender_">בחר מין</option>
        <option value="1" id="gedner_1">זכר</option>
        <option value="2" id="gedner_2">נקבה</option>
        <option value="3" id="gender_3">אחר</option>
    </select><br>
    גיל:<input type="number" name="age" value="<?= set_value('age', '{Age}') ?>"><br>
    עיר:<input type="text" name="city" value="<?= set_value('city', '{City}') ?>"><br>
    כתובת:<input type="text" name="address" value="<?= set_value('address', '{Address}') ?>"><br>
    טלפון:<input type="text" name="phone" value="<?= set_value('phone', '{Phone}') ?>"><br>
    <input type="submit" value="שנה פרטים">
    <div class="{message_class}">{message}</div>
</form>
{/user}
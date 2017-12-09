<form action="{base_url}managecategories/add" method="post" class="form">
    שם קטגוריה:<input type="text" name="title" value="<?= set_value('title') ?>"><br>
    סדר:<input type="number" name="order" value="<?= set_value('order') ?>"><br>
    תאור:<input type="text" name="desc" value="<?= set_value('desc') ?>"/><br>
    תמונה:<input type="text" name="image" value="<?= set_value('image') ?>"><br>
    מיועד למבוגרים:<input type="checkbox" name="isAdults" <?= isset($_POST['isAdults']) ? 'checked' : '' ?>><br>
    קטגוריית הורה:<select name="parent">
        <option value="0">ללא</option>
        {categories}
            <option value="{CatId}">{Title}</option>
        {/categories}
    </select><br>
    <input type="submit" value="הוספת קטגוריה">
    <div class="{message_class}">{message}</div>
</form><br>
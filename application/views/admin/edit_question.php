{question}
<form action="{base_url}category/edit/{ID}" method="post">
    שאלה: <input type="text" name="title" value="<?= set_value('title', '{Question}') ?>"><br>
    <input type="submit" value="עדכן שאלה">
    <div class="{message_class}">{message}</div>
</form>
{/question}
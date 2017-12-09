{answer}
<form action="{base_url}question/edit/{ID}/{qId}" method="post">
    תמונה: <input type="text" name="image" value="<?= set_value('image', '{ImgUrl}') ?>"><br><br>
    <textarea name="content">{Answer}</textarea>
    <input type="submit" value="עדכן תשובה">
    <div class="{message_class}">{message}</div>
</form>
{/answer}
<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'content' );    
</script>
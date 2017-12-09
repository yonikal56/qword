{question}
<a href="{base_url}category/{q_cat}" class="link_button">חזרה לקטגוריה</a><br><br><br>
<img src="{base_url}images/uploads/{QuesImg}" class="ques_img">
<div class="question">
    נשאל על ידי:<a class="asker_prof" href="{base_url}profile/id/{UserId}">{UserName}</a><br>
    {Question}
    <?php if($this->site_model->if_connected()): ?>
        <?php if($this->site_model->is_admin($_COOKIE['username'])): ?>
            <a href="{base_url}category/remove/{qId}/{q_cat}"><img src="{base_url}images/delete.png" width="16" height="16"></a>
            <a href="{base_url}category/edit/{qId}"><img src="{base_url}images/edit.png" width="16" height="16"></a>
        <?php endif; ?>
    <?php endif; ?><br>
    תגים: 
    {tags}
    <a href="{base_url}tag/{tag_name}">{tag_name}</a>
    {/tags}
</div>

<h1 class="sub_title">תשובות</h1>
<div class="clear"></div>
<ul class="question_answers">
    {answers}
        {imgAns}
        <li class="question_answer" id="answer_{AnsID}">
            נענה על ידי:<a class="asker_prof" href="{base_url}profile/id/{UserId}">{UserAns}</a><br><br>
            {Answer}
            <?php if($this->site_model->if_connected()): ?>
                <?php if($this->site_model->is_admin($_COOKIE['username'])): ?>
                    <a href="{base_url}question/remove/{AnsID}/{qId}"><img src="{base_url}images/delete.png" width="16" height="16"></a>
                    <a href="{base_url}question/edit/{AnsID}/{qId}"><img src="{base_url}images/edit.png" width="16" height="16"></a>
                <?php endif; ?>
            <?php endif; ?>
        </li>
    {/answers}
</ul>
<div class="clear"></div>
<h2>הגב</h2>
<form action="<?= $this->site_model->if_connected() ? '{base_url}question/add/{qId}' : '{base_url}user/register' ?>" method="post">
    תמונה: <input type="url" name="image"><br><br>
    <center><textarea name="content"></textarea></center>
    <br><input type="submit" value="שלח תשובה">
</form>

{/question}
<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'content' );
CKEDITOR.config.width = '90%';
</script>
<h2 class="sub_title">{more_cat_text}</h2><br>
       <strong>
         <ul class="randoms-row">
                {random_cat}
                <li class="random"><a href="{base_url}question/{qId}">

<center>
<img width="200" height="150" src="{base_url}images/uploads/{QuesImg}">
<center/>
{Question}</a></li>
                {/random_cat}
                </ul>
            </div>
<strong/>
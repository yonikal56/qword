{Desc}
<h2 class="sub_title">יצירת שאלה</h2>
<form action="<?= $this->site_model->if_connected() ? '{base_url}category/add/{CIC}' : '{base_url}user/register' ?>" method="post" class="form">
    שאלה:<input type="text" name="title">
    <br><input type="submit" value="צור שאלה">
</form>
<ul class="sub_categories">
    <h3 class="sub_title">תת קטגוריות</h3>
    {categories}
        <li class="sub_category">
            <a href="{base_url}category/cat/{CatId}">{Title}</a>
        </li>
    {/categories}
</ul>
<ul class="category_questions">
    <h3 class="sub_title">שאלות שנענו</h3>
    {aquestions}
        <li class="category_question">
            <a href="{base_url}question/{qId}">{Question}</a>
        </li>
    {/aquestions}
</ul>

<ul class="category_questions">
    <h3 class="sub_title">שאלות שלא נענו</h3>
    {nquestions}
        <li class="category_question">
            <a href="{base_url}question/{qId}">{Question}</a>
        </li>
    {/nquestions}
</ul>
<div class="clear"></div>
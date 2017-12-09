<ul class="sub_categories" style="width: 350px;">
    <h3 class="sub_title">שאלות שנענו</h3>
    {aquestions}
        <li class="sub_category">
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
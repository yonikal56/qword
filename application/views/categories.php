<ul class="categories">
    {categories}
        <a href="{base_url}category/cat/{CatId}" class='category'>
            <li>
                {Title}<br>
                <img src='{base_url}images/uploads/{IconFilename}'>
            </li>
        </a>
    {/categories}
</ul>
<center>
    <ul class="category_questions" style="width: 350px;">
        <h3 class="sub_title">שאלות שנענו לאחרונה</h3>
        {aquestions}
            <li class="category_question">
                <a href="{base_url}question/{qId}">{Question}</a>
            </li>
        {/aquestions}
    </ul>

    <ul class="sub_categories" style="width: 350px;">
        <h3 class="sub_title">שאלות שנשאלו לאחרונה</h3>
        {nquestions}
            <li class="category_question">
                <a href="{base_url}question/{qId}">{Question}</a>
            </li>
        {/nquestions}
    </ul>
</center>
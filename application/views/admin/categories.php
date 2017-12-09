<a href="{base_url}managecategories/add">הוספת קטגוריה</a>
<table border="1">
    <tr>
        <th>מזהה קטגוריה(ID)</th>
        <th>קטגוריות הורה</th>
        <th>סדר</th>
        <th>כותרת</th>
        <th>תמונת קטגורייה</th>
        <th>מיועד למבוגרים</th>
        <th>עריכה</th>
        <th>מחיקה</th>
    </tr>
    {categories}
        <tr>
            <td>{CatId}</td>
            <td>{parent}</td>
            <td>{OrderId}</td>
            <td>{Title}</td>
            <td>{IconFilename}</td>
            <td>{isAdults}</td>
            <td><a href="{base_url}managecategories/edit/{CatId}">ערוך</a></td>
            <td><a href="{base_url}managecategories/remove/{CatId}">מחק</a></td>
        </tr>
    {/categories}
</table>
{pages}
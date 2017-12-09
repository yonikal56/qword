<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' type="text/css" href='{base_url}css/style.css'>
        <title>{title}</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/png" href="{base_url}images/logo.png"/>
        <meta charset="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{description}">
        <meta name="keywords" content="{keywords}">
        <style>
            @font-face {
                font-family: 'anka_clmbold';
                src: url('{base_url}fonts/ankaclm-bold-webfont.eot');
                src: url('{base_url}fonts/ankaclm-bold-webfont.eot?#iefix') format('embedded-opentype'),
                     url('{base_url}fonts/ankaclm-bold-webfont.woff') format('woff'),
                     url('{base_url}fonts/ankaclm-bold-webfont.ttf') format('truetype'),
                     url('{base_url}fonts/ankaclm-bold-webfont.svg#anka_clmbold') format('svg');
                font-weight: normal;
                font-style: normal;
            }
            
            @font-face {
                font-family: 'yehuda_clm';
                src: url('{base_url}fonts/yehudaclm-light-webfont.eot');
                src: url('{base_url}fonts/yehudaclm-light-webfont.eot?#iefix') format('embedded-opentype'),
                     url('{base_url}fonts/yehudaclm-light-webfont.woff') format('woff'),
                     url('{base_url}fonts/yehudaclm-light-webfont.ttf') format('truetype'),
                     url('{base_url}fonts/yehudaclm-light-webfont.svg#yehuda_clmlight') format('svg');
                font-weight: normal;
                font-style: normal;

            }
        </style>
    </head>
    <body>
        <main class="page-wrap">
            <header class="header">
                <a href="{base_url}"><img class="logo" src="{base_url}images/logo.png"></a>
                <ul class="tabs">
                    {tabs}
                        <li class="tab">
                            <a href="{base_url}{tab_url}">{tab_text}</a>
                        </li>
                    {/tabs}
                </ul>
                <span class="logo_text">ברוכים הבאים לאתר קיווורד, באתר תוכלו למצוא מאגר גדול של מידע מסודר על פי נושאים ותחומים. בנוסף לכך אתם יכולים גם לקחת חלק באתר בכך שתשאלו/תענו על השאלות השונות</span>
            </header>
            <div class="quick_question">
                <form action="<?= $this->site_model->if_connected() ? '{base_url}category/add' : '{base_url}user/register' ?>" method="post" class="form">
                    <input type="text" name="title"> &nbsp;
                    <select name="category">
                        {categories}
                            <option value="{CatId}">{Title}</option>
                        {/categories}
                    </select> &nbsp;
                    <input type="submit" value="שאלה מהירה">
                </form>
            </div>
            <div class='clear'></div>
            <div class="sidebar">
                <form action="http://xn--7dbdaar7fl.com/" id="cse-search-box">
                    <div>
                        <input type="hidden" name="cx" value="partner-pub-9100989193392045:8344545812" />
                        <input type="hidden" name="cof" value="FORID:10" />
                        <input type="hidden" name="ie" value="UTF-8" />
                        <input type="text" name="q" />
                        <input type="submit" name="sa" value="חיפוש" />
                    </div>
                </form>

                  <script type="text/javascript" src="http://www.google.co.il/coop/cse/brand?form=cse-search-box&amp;lang=iw"></script>
                <div id="cse-search-results"></div>	<script type="text/javascript">	  var googleSearchIframeName = "cse-search-results";	  var googleSearchFormName = "cse-search-box";	  var googleSearchDomain = "www.google.co.il";	  var googleSearchPath = "/cse";	</script>	<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
                 
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- qword1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1124161111604969"
     data-ad-slot="3174879538"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>            
 <br><br><hr>

<br><br><h2 class="sub_title">אולי יעניין אותך</h2><br>
       <strong>
         <ul class="randoms">
                {random}
                <li class="random"><a href="{base_url}question/{qId}">

<center>
<img src="{base_url}images/uploads/{QuesImg}">
<center/>
{Question}</a></li>
                {/random}
                </ul>
            </div>
<strong/>
            <div class='content'>
                <h1 class='title'>{title}</h1>
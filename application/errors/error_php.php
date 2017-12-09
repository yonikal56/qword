<style>
	div.php_error {
		border:1px solid #990000;
		padding-left:20px;
		margin:0 auto;
		text-align: center;
		direction: rtl;
		width: 35%;
	}
</style>

<meta charset="UTF-8">

<div class="php_error">

<h4>קרתה שגיאת PHP</h4>

<p>חומרת שגיאה: <?php echo $severity; ?></p>
<p>שגיאה:  <?php echo $message; ?></p>
<p>קובץ: <?php echo $filepath; ?></p>
<p>שורת שגיאה: <?php echo $line; ?></p>

</div>
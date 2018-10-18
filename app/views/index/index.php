<?php
include 'include/header.php';
?>
<h1>Page index</h1>
<?php
echo  $this->message;
echo 'Vue : index/index.php<br />';
?>
<b>Contenu html</b>

<form method="post" action="<?php echo $this->url(); ?>">
	<label>Age : </label><input type="text" value="" name="age" />
	<input type="submit" value="Envoyer" />
</form>
<?php
include 'include/footer.php';
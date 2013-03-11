<?php 
if (!empty($error)) {
	echo $error;
}?>

<?php
	
	foreach($document_data as $document) {
		?>
		<article class="align-center highlight"><a href="<?=$document['doc_uri'];?>" class="orange-button" ><?=$document['doc_name'];?></a></article>
	<?php
	}
	?>
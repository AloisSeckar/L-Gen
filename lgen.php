<html lang="cs">
	<head>
		<title>L-Gen</title>
		<meta charset="UTF-8">
		<meta name="description" content="L-Gen - vkládání loga do obrázku">
		<meta name="keywords" content="Obrázky, Watermark, Politika, Volby, ODS, STAN, Jihomoravský kraj">
		<meta name="author" content="Alois Sečkár">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link href="lgen.css" rel="stylesheet">
	</head>
	
	<body>
	<?php
		$message = "Vyberte obrázek pro vložení loga (JPG nebo PNG)";
		$alert_type = "alert-info";
		$output = null;
		$img_dir = "tmp/";
		$source_file = $img_dir . "input";
		$target_file = $img_dir . "output.png";
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		if(isset($_FILES["fileToUpload"])) {
			try {
				$mime = $_FILES["fileToUpload"]["type"];
				$check = $mime == "image/jpeg" || $mime == "image/png";
				if($check !== false) {
					
					if (file_exists($source_file)) {
						unlink($source_file);
					}
					if (file_exists($target_file)) {
						unlink($target_file);
					}
					
					
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $source_file)) {
						
						$im = imagecreatefromstring(file_get_contents($source_file));
						
						$stamp = imagecreatefrompng('stamp.png');
						$stamp_size = intval(imagesy($im) / 8);
						$margin = 10;
						
						$x_coord = imagesx($im) - $margin - $stamp_size;
						$y_coord = imagesy($im) - $margin - $stamp_size;
						
						imagecopyresampled($im, $stamp, $x_coord, $y_coord, 0, 0, $stamp_size, $stamp_size, imagesx($stamp), imagesy($stamp));
						imagepng($im, $target_file);
						imagedestroy($im);
						
						$output = $target_file;
						
						$message = "Soubor ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " byl zpracován";
						$alert_type = "alert-success";
						
					} else {
						$message = "Při zpracování souboru došlo k chybě";
						$alert_type = "alert-danger";
					}
				} else {
					$message = "Soubor není obrázek povoleného typu (JPG nebo PNG)";
					$alert_type = "alert-danger";
				}
			} catch (Exception $e) {
				$message = "Při zpracování souboru došlo k chybě";
				$alert_type = "alert-danger";
			} 
		}
		
	?> 
	
		<div class="container text-center">
			<h1>L-Gen</h1>
			<div class="row">
				<div class="alert <?=$alert_type;?>"><?=$message;?></div>
			</div>
			<div class="row">
				<form class="form-inline" action="lgen.php" method="post" enctype="multipart/form-data">
					<input type="file" name="fileToUpload" id="fileToUpload" style="display:none;" onchange="this.form.submit();" ondrag="this.form.submit();"/>
					<label for="fileToUpload" id="img-area" ondrag="this.form.submit();">Kliknutím vyberte soubor</label>
				</form>
			</div>
			<hr />
			<div class="row">
				<?php if (isset($output)) { ?>
					<p><img src="<?=$output . "?" . filemtime($output) ;?>" /></p>
				<?php } ?>
			</div>
			<hr />
			<div class="row">
				<p class="font-weight-light"><a href="http://alois-seckar.cz">Alois Sečkár</a> 2021 | <a href="https://unlicense.org/">UNLICENSE</a></p>
			</div>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
		
	</body>
</html>
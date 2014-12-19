<html>
	<body>
		<?php
			//Add Device Atlas to the php block:
		include "DA_12/Mobi/Mtld/DA/Api.php";
		//fetch the database of properties
		$tree = Mobi_Mtld_DA_Api::getTreeFromFile("DA_12/sample/json/DeviceAtlas.json");
		//Get the User Agent Header sent by Device
		$ua = $_SERVER['HTTP_USER_AGENT'];
		//Which vendor? Get the ‘vendor’ property
		    try{
		        $pngSupport =  Mobi_Mtld_DA_Api::getProperty($tree, $ua, 'image.Png');
		    } catch (Mobi_Mtld_Da_Exception_InvalidPropertyException $e) {
		        $pngSupport = false; //You may wish to have some other fallback (like assuming true for unknown)
		    }
		    if($pngSupport): //Supports PNG images
		        try{
		            $displayWidth =  Mobi_Mtld_DA_Api::getProperty($tree, $ua, 'image.Png');
		        } catch (Mobi_Mtld_Da_Exception_InvalidPropertyException $e) {
		                $displayWidth = 128; //Default to 128 for unknown
		        }
				
		        if($displayWidth >= 240){
		            $image = 'ashesiLogo_239x107.png';
		            $width = 239;
		            $height = 107;
		        } else {
		       		$image = 'student_128x57.png';
		            $width = 128;
		            $height = 57;
		        }

		//$vendor = Mobi_Mtld_DA_Api::getProperties($tree, $ua, 'displayWidth');
		 //$tree = Mobi_Mtld_DA_Api::getTreeFromFile("DA_12/sample/Sample.json");
		 //$prps = Mobi_Mtld_DA_Api::getProperties($tree, "Nokia6680...");
		 //$prop = Mobi_Mtld_DA_Api::getProperty($tree, $ua, "displayWidth");
		echo $displayWidth;
		?>
		    <p><img id="logo" src="img/<?php echo $image; ?>" 
          alt="dotMobi Logo" width="<?php echo $width; ?>" 
          height="<?php echo $height; ?>"/></p>
    <?php endif; ?>
		
	</body>
</html>
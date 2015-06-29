<?php  
	if( 'POST' == $_SERVER['REQUEST_METHOD']  ) {
	if ( $_FILES ) { 
			$files = $_FILES["bux_multiple_attachments"];  
			foreach ($files['name'] as $key => $value) { 			
					if ($files['name'][$key]) { 
						$file = array( 
							'name' => $files['name'][$key],
		 					'type' => $files['type'][$key], 
							'tmp_name' => $files['tmp_name'][$key], 
							'error' => $files['error'][$key],
	 						'size' => $files['size'][$key]
						); 
						$_FILES = array ("bux_multiple_attachments" => $file); 
						foreach ($_FILES as $file => $array) {				
							$newupload = kv_handle_attachment($file,$pid); 
						}
					} 
				} 
			}

	}
?>
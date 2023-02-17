<?php
namespace App\Export;
/*  Gelsheet Project, version 0.0.1 (Pre-alpha)
 *  Copyright (c) 2008 - Ignacio Vazquez, Fernando Rodriguez, Juan Pedro del Campo
 *
 *  Ignacio "Pepe" Vazquez <elpepe22@users.sourceforge.net>
 *  Fernando "Palillo" Rodriguez <fernandor@users.sourceforge.net>
 *  Juan Pedro "Perico" del Campo <pericodc@users.sourceforge.net>
 *
 *  Gelsheet is free distributable under the terms of an GPL license.
 *  For details see: http://www.gnu.org/copyleft/gpl.html
 *
 */

	class PHPExcel_Output {
		/*this controller manages the export functions*/

		private $file;
		private $book;
		private $objPHPExcel;
		private $objPHPOds;

		/*constructs*/

		/*the construct gets the book id for the exportation*/
		public function __construct() {}

		public function __destruct() {}

		/**
		 * Enter description here...
		 *
		 * @param PHP_Excel $phpexcel
		 * @param String $format
		 */
		function writeExcel($phpexcel, $filename = '', $format="xls") {
			
			if(!$filename) {
				$filename= "tmp" . DS ."default-".rand(1,9999);
			}
			
			
			$filepath = XPATH_BASE . DS . $filename . '.' . $format;
			$currentDir=  XPATH_BASE . DS . XConfig::$path['tmp'] ;  // Get the Storage Folder
			
			switch($format){
	
			case "pdf":
						require_once PHPEXCEL_ROOT . 'PHPExcel' . DS . 'Writer'. DS .'PDF.php';
						$objWriter1 = new PHPExcel_Writer_PDF($phpexcel);
						$objWriter1->writeAllSheets();
						$objWriter1->setTempDir($currentDir);
						$objWriter1->save("$filename.$format");	//save the object to a pdf file
						break;
	
			case "xls":
						require_once PHPEXCEL_ROOT . 'PHPExcel' . DS . 'Writer'. DS .'Excel5.php';
						$objWriter2 = new PHPExcel_Writer_Excel5($phpexcel);
						$objWriter2->setTempDir($currentDir);
						$objWriter2->save("$filename.$format");	//save the object to a xls file
						break;
	
			case "xlsx":
						require_once PHPEXCEL_ROOT . 'PHPExcel' . DS . 'Writer'. DS .'Excel2007.php';
						$objWriter3 = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
						$objWriter3->save($currentDir."$filename.$format"); //save the object to a xlsx file
						break;
	
			case "csv":
						require_once PHPEXCEL_ROOT . 'PHPExcel' . DS . 'Writer'. DS .'CSV.php';
						$objWriter4 = new PHPExcel_Writer_CSV($phpexcel);
						//$objWriter4->setTempDir($currentDir);
						$objWriter4->setDelimiter(';');
						$objWriter4->setEnclosure('');
						$objWriter4->setLineEnding("\r\n");
						$objWriter4->save("$filename.$format");	//save the object to a CSV file
						break;
						
			case "html":
						require_once PHPEXCEL_ROOT . 'PHPExcel' . DS . 'Writer'. DS .'HTML.php';
						$objWriter5 = new PHPExcel_Writer_HTML($phpexcel);
						$objWriter5->writeAllSheets();
						//$objWriter5->setTempDir($currentDir);
						$objWriter5->save("$filename.$format");	//save the object to a HTML file
						break;
			}
			
			$this->_send($filepath, $format, 'export.' . $format);
			
		}
		
		/**
		 * Sends HTTP Headers to Download Archive...
		 *
		 * @param String $filename
		 */
		function _send($file, $format, $filename, $isDelete = true){
		    //This will set the Content-Type to the appropriate setting for the file
		    switch( $format ) {
	          case "pdf": $ctype="application/pdf"; break;
		      case "exe": $ctype="application/octet-stream"; break;
		      case "zip": $ctype="application/zip"; break;
		      case "doc": $ctype="application/msword"; break;
		      case "xls": $ctype="application/vnd.ms-excel"; break;
		      case "xlsx": $ctype="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"; break;
		      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		      case "gif": $ctype="image/gif"; break;
		      case "png": $ctype="image/png"; break;
		      case "jpeg":
		      case "jpg": $ctype="image/jpg"; break;
		      case "mp3": $ctype="audio/mpeg"; break;
		      case "wav": $ctype="audio/x-wav"; break;
		      case "mpeg":
		      case "mpg":
		      case "mpe": $ctype="video/mpeg"; break;
		      case "mov": $ctype="video/quicktime"; break;
		      case "avi": $ctype="video/x-msvideo"; break;
		
		      //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
		      case "php":
		      case "htm":
		      case "html":
		      case "txt": die("<b>Cannot be used for ". $format ." files!</b>"); break;
		
		      default: $ctype="application/force-download";
		    }
		
		    //Begin writing headers
		    header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    header("Cache-Control: public");
		    header("Content-Description: File Transfer");
		   
		    //Use the switch-generated Content-Type
		    header("Content-Type: $ctype");			    
		    $header="Content-Disposition: attachment; filename=".$filename.";";
		    header($header);
		    header("Content-Transfer-Encoding: binary");
		    @readfile($file);
		    if($isDelete)
				unlink($file) ;
		}
	}

?>
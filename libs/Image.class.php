<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Image {		
		private static $supportedTypes = array(
			IMAGETYPE_JPEG,
			IMAGETYPE_GIF,
			IMAGETYPE_PNG,
		);
		
		protected $imagePath 	= NULL;
		protected $extension	= NULL;
		protected $isSupported	= NULL;
		protected $MIME			= NULL;
		protected $size			= 0;
		protected $width		= 0;
		protected $height		= 0;
		protected $ratio		= NULL;
		protected $imageType	= NULL;
		protected $fileHandler	= NULL;
		protected $imageHandler	= NULL;
		
		public $maintainRatio	= true;
		
		public function __construct($imagePath) {
			$this->imagePath = $imagePath;
		}
		
		public function __destruct() {
			if(!empty($this->imageHandler)) {
				imagedestroy($this->imageHandler);
			}
		}
		
		public function init() {
			$this->getExtension();
			$this->getSize();
			$this->getDimension();
			$this->getImageType();
			$this->getImageHandler();
			$this->isSupported();
			$this->getMIME();
		}
		
		public function reset() {
			$this->imagePath = NULL;
			$this->extension = NULL;
			$this->isSupported = NULL;
			$this->size = 0;
			$this->width = 0;
			$this->height = 0;
			$this->ratio = 0;
			$this->imageType = NULL;
			$this->fileHandler = NULL;
			$this->imageHandler = NULL;			
		}
		
		public function getImageHandler() {			
			if(empty($this->imageHandler)) {
				switch($this->getImageType()) {
					case IMAGETYPE_GIF:
						$this->imageHandler = imagecreatefromgif($this->imagePath);
					break;
					case IMAGETYPE_JPEG:
						$this->imageHandler = imagecreatefromjpeg($this->imagePath);
					break;
					case IMAGETYPE_PNG:
						$this->imageHandler = imagecreatefrompng($this->imagePath);
					break;
				}
			}
			
			return $this->imageHandler;
		}
		
		public function getFileHandler() {
			if(empty($this->fileHandler)) {
				App::load()->lib('ImageFile', '/File');
				
				$this->fileHandler = new ImageFile($this->imagePath);
			}
			
			return $this->fileHandler;
		}
		
		public function getExtension() {
			if(empty($this->extension)) {
				$this->extension = pathinfo($this->imagePath, PATHINFO_EXTENSION);
			}
			
			return $this->extension;
		}
		
		public function getMIME() {
			if(empty($this->MIME)) {
				App::load()->lib('MIME');
				$this->MIME = MIME::getInstance()->__get($this->getExtension());
			}
			
			return $this->MIME;
		}
		
		public function getImageType() {
			if(empty($this->imageType)) {
				$this->imageType = exif_imagetype($this->imagePath);
			}
			
			return $this->imageType;
		}
		
		public function getSize() {
			if(empty($this->size)) {
				$this->size = $this->fileHandler->size();
			}
			
			return $this->size;
		}
		
		public function getRatio() {
			if(empty($this->ratio)) {
				$this->ratio = $this->getWidth() / $this->getHeight();
			}
			
			return $this->ratio;
		}
		
		public function getWidth() {
			if(empty($this->width)) {
				$this->width = imagesx($this->getImageHandler());
			}
			
			return $this->width;
		}
		
		public function getHeight() {
			if(empty($this->height)) {
				$this->height = imagesy($this->getImageHandler());
			}
			
			return $this->height;
		}
		
		public function isSupported() {
			if(empty($this->isSupported)) {
				$this->isSupported = in_array($this->getImageType(), self::$supportedTypes);
			}
			
			return $this->isSupported;
		}
		
		protected function validateDimension($width, $height) {		
			return array(
				$width > $this->getWidth() ? $this->getWidth() : $width, 
				$height > $this->getHeight() ? $this->getHeight() : $height
			);
		}
		
		public function crop($x = 0, $y = 0, $width = NULL, $height = NULL) {
			if($width === NULL or $height === NULL) {
				return $this;
			}
			
			list($width, $height) = $this->validateDimension($width, $height);			
			
			$newImage = imagecreate($width, $height);
			
			if ($this->getImageType() == IMAGETYPE_PNG) {
				imagealphablending($newImage, FALSE);
				imagesavealpha($newImage, TRUE);
			}
			
			if(!imagecopyresampled($newImage, $this->getImageHandler(), 0, 0, $x, $y, $width, $height, $width, $height)) {			
				imagedestroy($newImage);
				
				throw new Exception('Failed to crop the image.');
			}
			
			imagedestroy($this->imageHandler);
				
			$this->imageHandler = $newImage;
			
			return $this;
		}
		
		public function cropCenter($width, $height) {
			list($width, $height) = $this->validateDimension($width, $height);
						
			$x = ($this->getWidth() - $width) / 2;
			$y = ($this->getHeight() - $height) / 2;
						
			return $this->crop($x, $y, $width, $height);
		}
		
		public function rotate($deg) {
			if(!($handler = imagerotate($this->getImageHandler(), $deg, 0))) {
				throw new Exception('Failed to rotate image.');
			}
			
			imagedestroy($this->imageHandler);
			
			$this->imageHandler = $handler;
			
			return $this;
		}
		
		public function resizeTo($w = NULL, $h = NULL) {
			if($w === NULL and $h === NULL) {
				return $this;
			}
			
			if($w === NULL and $h !== NULL) {
				$height = $h;
				
				if($this->maintainRatio) {
					$width = round($height * $this->getRatio());
				} else {
					$width = $this->getWidth();
				}
			} else if($h === NULL and $w !== NULL) {
				$width = $w;
				
				if($this->maintainRatio) {
					$height = round($width / $this->getRatio());
				} else {
					$height = $this->getHeight();
				}
			} else {
				$width = $w;
				$height = $h;
			}
			
			$newImage = imagecreatetruecolor($width, $height);
			
			if ($this->getImageType() == IMAGETYPE_PNG) {
				imagealphablending($newImage, FALSE);
				imagesavealpha($newImage, TRUE);
			}			
			
			if(!imagecopyresampled($newImage, $this->getImageHandler(), 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight())) {
				imagedestroy($newImage);
				
				throw new Exception('Failed to resize image.');				
			}
			
			imagedestroy($this->imageHandler);
			
			$this->imageHandler = $newImage;			

			return $this;
		}
		
		protected function drawGIF($savePath = NULL) {
			if($savePath === NULL) {
				return imagegif($this->getImageHandler());
			}
			
			return imagegif($this->getImageHandler(), $savePath);
		}
		
		protected function drawJPEG($savePath = NULL) {
			if($savePath === NULL) {
				return imagejpeg($this->getImageHandler());
			}
			
			return imagejpeg($this->getImageHandler(), $savePath);
		}
		
		protected function drawPNG($savePath = NULL) {
			if($savePath === NULL) {
				return imagepng($this->getImageHandler());				
			}
			
			return imagepng($this->getImageHandler(), $savePath);
		}
		
		public function saveTo($savePath, $overwrite = false) {			
			if(!$overwrite and is_file($savePath)) {
				throw new Exception('Filename you specified is already exists on the directory.');
			}
			
			switch($this->getImageType()) {
				case IMAGETYPE_GIF:
					$this->drawGIF($savePath);
				break;
				case IMAGETYPE_JPEG:
					$this->drawJPEG($savePath);
				break;
				case IMAGETYPE_PNG:
					$this->drawPNG($savePath);
				break;
			}
						
			return $this;
		}
		
		public function saveAs($type, $savePath, $overwrite = false) {
			if(in_array($type, self::$supportedTypes)) {
				$this->imageType = $type;
			}
			
			return $this->saveTo($savePath, $overwrite);
		}
		
		public function render() {
			Response::getInstance()->startBuffering();
			switch($this->getImageType()) {
				case IMAGETYPE_GIF:
					$this->drawGIF();
				break;
				case IMAGETYPE_JPEG:
					$this->drawJPEG();
				break;
				case IMAGETYPE_PNG:
					$this->drawPNG();
				break;
			}
			$content = Response::getInstance()->getBuffer(false);
			Response::getInstance()->endBuffering();
			return $content;
		}
		
		public function overWrite() {
			return $this->saveTo($this->imagePath, true);
		}
		
		public function URIScheme() {			
			return sprintf('data:%s;base64,%s', $this->getMIME(), base64_encode($this->render()));
		}
		
		public function toTag() {
			return HTML('img')->setAttr('src', $this->URIScheme());
		}
		
		public function __toString() {
			Response::getInstance()->setContentType($this->getExtension());
			
			return $this->render();
		}
	}
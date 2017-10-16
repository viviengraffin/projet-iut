<?php
	$text="on m'appelle l'ovni";
	echo "original : ".$text."<br/>";
	echo "sha224 : ".sha224($text)."<br/>";
	echo "sha256 : ".sha256($text)."<br/>";
	echo "sha512 : ".sha512($text);

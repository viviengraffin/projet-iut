<?php
	Cookie::setKey("on m'appelle l'ovni");
	if(!Cookie::has("wesh")){
		Cookie::set("wesh","alors",3600);
	}
	else{
		echo Cookie::get("wesh");
	}

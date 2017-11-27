var chronometre={}
chronometre.chronos=[]

chronometre.createChrono=function(){
	var chrono={}
	chrono.style="Il reste $m minutes et $s secondes"
	return(chrono)
}

chronometre.init=function(){
	htmls=document.querySelectorAll("span[chrono-second]")
	htmls.forEach(function(html){
		var chrono={}
		chrono=chronometre.createChrono()
		chrono.html=html
		chrono.minut=html.getAttribute("chrono-minut") || 0
		chrono.second=html.getAttribute("chrono-second")
		if(html.innerText!=""){
			chrono.style=html.innerText
		}
		chrono.setText=function(){
			var s=chrono.minut+"m"+chrono.second+"s"
			if(chrono.html.hasAttribute("chrono-color-"+s)){
				chrono.html.style.color=chrono.html.getAttribute("chrono-color-"+s)
			}
			if(chrono.html.hasAttribute("chrono-style-"+s)){
				chrono.style=chrono.html.getAttribute("chrono-style-"+s)
			}
			var res=chrono.style.replace("$m",chrono.minut)
			res=res.replace("$s",chrono.second)
			res=res.replace("$M",chronometre.get0time(chrono.minut))
			res=res.replace("$S",chronometre.get0time(chrono.second))
			chrono.html.innerText=res
		}
		chrono=chronometre.initChrono(chrono)
		chrono.setText()
		chrono.interval=setInterval(function(){
			var good=true
			if(chrono.second>0){
				chrono.second--
			}
			else if(chrono.minut>0){
				chrono.minut--
				chrono.second=59
			}
			else{
				clearInterval(chrono.interval)
				good=false
			}
			if(good){
				chrono.setText()
			}
		},1000)
		chronometre.chronos.push(chrono)
	})
}
chronometre.get0time=function(time){
	if(time<10){
		return("0"+time)
	}
	else{
		return(time)
	}
}
chronometre.initChrono=function(chrono){
	var attributes=chrono.html.attributes
	var i=0
	while(i<attributes.length){
		attribute=attributes[i]
		if(attribute.name.substr(0,12)=="chrono-color"){
			var t=chronometre.getTime(attribute.name.substr(13,attribute.name.length-13))
			if((t[0]>=chrono.minut)&&(t[1]>=chrono.second)){
				chrono.html.style.color=attribute.value
			}
		}
		else if(attribute.name.substr(0,12)=="chrono-style"){
			var t=chronometre.getTime(attribute.name.substr(13,attribute.name.length-13))
			if((t[0]>=chrono.minut)&&(t[1]>=chrono.second)){
				chrono.style=attribute.value
			}
		}
		i++
	}
	return(chrono)
}
chronometre.getTime=function(time){
	var i=0
	var minut=""
	var second=""
	var isMinut=true
	while(i<time.length){
		if(isMinut){
			if(time[i]!="m"){
				minut+=time[i]
			}
			else{
				isMinut=false
			}
		}
		else{
			if(time[i]!="s"){
				second+=time[i]
			}
		}
		i++
	}
	return([minut,second])
}

chronometre.init()

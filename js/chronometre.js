var chronometre={}
chronometre.chronos=[]


chronometre.createChrono=function(){
	var chrono={}
	chrono.style="Il reste $m minutes et $s secondes"
	chrono.asc=false
	return(chrono)
}
chronometre.init=function(){
	htmls=document.querySelectorAll("span[chrono-time]")
	htmls.forEach(function(html){
		var chrono={}
		chrono=chronometre.createChrono()
		chrono.html=html
		var t=chronometre.getTime(html.getAttribute("chrono-time"))
		chrono.minut=t[0]
		chrono.second=t[1]
		chrono.defaultMinut=t[0]
		chrono.defaultSecond=t[1]
		chrono.tcdefMinut=chronometre.get0time(chrono.minut)
		chrono.tcdefSecond=chronometre.get0time(chrono.second)
		if(html.hasAttribute("chrono-asc")){
			chrono.asc=true
			chrono.minut=0
			chrono.second=0
		}
		if(html.innerText!=""){
			chrono.style=html.innerText
		}
		chrono.setText=function(){
			var minut=chrono.minut
			var second=chrono.second
			var s=minut+"m"+second+"s"
			var rts=chronometre.getRTString(chrono)
			if(chrono.html.hasAttribute("chrono-color-"+s)){
				chrono.html.style.color=chrono.html.getAttribute("chrono-color-"+s)
			}
			if(chrono.html.hasAttribute("chrono-style-"+s)){
				chrono.style=chrono.html.getAttribute("chrono-style-"+s)
			}
			if(chrono.html.hasAttribute("chrono-style-"+rts)){
				chrono.style=chrono.html.getAttribute("chrono-style-"+rts)
			}
			if(chrono.html.hasAttribute("chrono-color-"+rts)){
				chrono.html.style.color=chrono.html.getAttribute("chrono-color-"+rts)
			}
			var p=chronometre.getPourcent(chrono)
			var res=chrono.style.replace("$m",minut)
			console.dir(res.replace("$mdef"))
			res=res.replace("$mdef",chrono.defaultMinut)
			res=res.replace("$sdef",chrono.defaultSecond)
			res=res.replace("$Sdef",chrono.tcdefSecond)
			res=res.replace("$Mdef",chrono.tcdefMinut)
			res=res.replace("$s",second)
			res=res.replace("$M",chronometre.get0time(minut))
			res=res.replace("$S",chronometre.get0time(second))
			res=res.replace("$p",p)
			res=res.replace("$P",chronometre.get0time(p))
			chrono.html.innerText=res
		}
		chrono=chronometre.initChrono(chrono)
		chrono.setText()
		chrono.interval=setInterval(function(){
			var good=true
			if(chrono.asc){
				if(chrono.second<59){
					if((chrono.minut==chrono.defaultMinut)&&(chrono.second>chrono.defaultSecond-1)){
						clearInterval(chrono.interval)
						good=false
					}
					else{
						chrono.second++
					}
				}
				else if(chrono.minut<chrono.defaultMinut){
					chrono.second=0
					chrono.minut++
				}
				else{
					clearInterval(chrono.interval)
					good=false
				}
			}
			else{
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
			var t=chronometre.getTimeT(attribute.name.substr(13,attribute.name.length-13),chrono)
			if(!chrono.asc){
				if((t[0]>=chrono.minut)&&(t[1]>=chrono.second)){
					chrono.html.style.color=attribute.value
				}
			}
			else{
				if((t[0]<=chrono.minut)&&(t[1]<=chrono.second)){
					chrono.html.style.color=attribute.value
				}
			}
		}
		else if(attribute.name.substr(0,12)=="chrono-style"){
			var t=chronometre.getTimeT(attribute.name.substr(13,attribute.name.length-13),chrono)
			if(!chrono.asc){
				if((t[0]>=chrono.minut)&&(t[1]>=chrono.second)){
					chrono.style=attribute.value
				}
			}
			else{
				if((t[0]<=chrono.minut)&&(t[2]<=chrono.second)){
					chrono.style=attribute.value
				}
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
	return([parseInt(minut),parseInt(second)])
}
chronometre.getTimeT=function(time,chrono){
	if(time[0]=="r"){
		if(chrono.asc){
			var r=chronometre.getTime(time.substr(1,time.length-1))
			var def=60*chrono.defaultMinut+chrono.defaultSecond
			var actual=60*r[0]+r[1]
			var diff=def-actual
			
			var minut=0
			var good=false
			while(!good){
				if(diff>=60){
					minut++
					diff-=60
				}
				else{
					good=true
				}
			}
			return([minut,diff])
		}
		else{
			return(chronometre.getTime(time.substr(1,time.length-1)))
		}
	}
	else{
		return(chronometre.getTime(time))
	}
}
chronometre.getRTString=function(chrono){
	if(chrono.asc){
		var actual=60*chrono.minut+chrono.second
		var def=60*chrono.defaultMinut+chrono.defaultSecond
		var diff=def-actual
		var minut=0
		var good=false
		
		while(!good){
			if(diff>=60){
				minut++
				diff-=60
			}
			else{
				good=true
			}
		}
	}
	else{
		var minut=chrono.minut
		var diff=chrono.second
	}
	return("r"+minut+"m"+diff+"s")
}
chronometre.getPourcent=function(chrono){
	if(chrono.asc){
		var def=60*chrono.defaultMinut+chrono.defaultSecond
		var actual=60*chrono.minut+chrono.second
		var div=actual/def
		return(parseInt(div*100))
	}
	else{
		var def=60*chrono.defaultMinut+chrono.defaultSecond
		var actual=60*chrono.minut+chrono.second
		actual=def-actual
		var div=actual/def
		return(parseInt(div*100))
	}
}

chronometre.init()

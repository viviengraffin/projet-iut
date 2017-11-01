var hse=Element.prototype
if(!hse.addEventListener){
	if(hse.attachEvent){
		hse.addEventListener=function(a,b){
			this.attachEvent(a,b)
		}
		hse.removeEventListener=function(a,b){
			this.detachEvent(a,b)
		}
	}
	else{
		hse.addEventListener=function(a,b){
			if(a==="change"){
				this.onChange=b
			}
			else if(a=="reset"){
				this.onReset=b
			}
		}
		hse.removeEventListener=function(a,b){
			if(a==="change"){
				this.onChange=null
			}
			else if(a=="reset"){
				this.onReset=null
			}
		}
	}
}
hse=undefined
var date={}
date.set={}
date.defaultValues={}
date.defaultValues.ymi=1800
date.defaultValues.yma=2200
date.defaultValues.language=navigator.languages[0] || navigator.language || navigator.userLanguage || "en"
date.attributes={}
date.attributes.npd="no-past-date"
date.attributes.nfd="no-future-date"
date.attributes.dd="date-day"
date.attributes.dm="date-month"
date.attributes.dy="date-year"
date.attributes.ymi="year-min"
date.attributes.yma="year-max"
date.attributes.def="default"
date.attributes.ml="month-label"
date.attributes.rmn="return-month-name"
date.attributes.tcd="two-char-day"
date.attributes.tcm="two-char-month"
date.attributes.ry="reverse-year"
date.attributes.tcdl="two-char-day-label"
date.attributes.tcml="two-char-month-label"
date.attributes.empty="null"
date.attributes.limit="limit"
date.attributes.dor="date-on-reset"
date.attributes.std="search-today-date"
date.getDpm=function(){
	return([31,28,31,30,31,30,31,31,30,31,30,31])
}
date.getDpmY=function(annee){
	var ret=date.getDpm()
	if(date.isbissextile(annee)){
		ret[1]++
	}
	return(ret)
}
date.getNbDayMonth=function(mois,annee){
	var ret=new Date(annee,mois,0)
	return(ret.getDate())
}
date.setlistid=[]
date.listOfSelect=function(){
	date.days=document.querySelectorAll("select["+date.attributes.dd+"]")
	date.months=document.querySelectorAll("select["+date.attributes.dm+"]")
	date.years=document.querySelectorAll("select["+date.attributes.dy+"]")
}
date.language={}
date.language["fr"]=["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre","Jour","Mois","Année"]
date.language["en"]=["January","February","March","April","May","June","July","August","September","October","November","December","Day","Month","Year"]
date.language["es"]=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre","Día","Mes","Año"]
date.language["it"]=["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre","Giorno","Mese","Anno"]
date.language["ge"]=["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember","Tag","Monat","Jahr"]
if(date.defaultValues.language.length>2){
	date.defaultValues.language=date.defaultValues.language.substr(0,2)
}
if(typeof(date.language[date.defaultValues.language])=="undefined"){
	date.defaultValues.language="en"
}
date.init=function(){
	date.listOfSelect()
	var years=date.years
	var i=0
	
	if(t=document.querySelector("select["+date.attributes.std+"]")){
		console.dir(t)
		var xhr=new XMLHttpRequest()
		var links=t.getAttribute(date.attributes.std).split(";")
		var good=false
		var i=0
		
		while((i<links.length)&&(!good)){
			xhr.open("GET",links[i])
			xhr.send(null)
			
			if(xhr.readyState === XMLHttpRequest.DONE){
				if(xhr.status===200){
					good=true
					t=JSON.parse(xhr.responseText)
					var today=new Date(t.year,t.month,t.day)
				}
			}
			else{
				i++
			}
		}
		if(!good){
			console.error("Error to connect on server")
			return(undefined)
		}
	}
	else{
		var today=new Date()
	}
	while(i<years.length){
		var daypermonth=date.getDpm()
		j=0
		if(!date.isset(years[i].getAttribute(date.attributes.dy))){
			var year=years[i]
			var id=year.getAttribute(date.attributes.dy)
			var month=date.searchMonthSelect(id) || date.getEmptyDay()
			var day=date.searchDaySelect(id) || date.getEmptyDay()
			date.set[id]={}
			date.set[id].year=year
			date.set[id].month=month
			date.set[id].day=day
			var ymi=date.defaultValues.ymi
			var yma=date.defaultValues.yma
			if(date.hasAttribute(id,date.attributes.ymi)){
				ymi=year.getAttribute(date.attributes.ymi)
			}
			if(date.hasAttribute(id,date.attributes.yma)){
				yma=year.getAttribute(date.attributes.yma)
			}
			var ydef=""
			if(year.hasAttribute(date.attributes.def)){
				ydef=year.getAttribute(date.attributes.def)
				if(ydef=="t"){
					ydef=today.getFullYear()
				}
				else{
					ydef=parseInt(ydef)
				}
			}
			var mdef=""
			if(month.hasAttribute(date.attributes.def)){
				mdef=month.getAttribute(date.attributes.def)
				if(mdef=="t"){
					mdef=today.getMonth()+1
				}
				else{
					mdef=parseInt(mdef)
				}
			}
			var ddef=""
			if(day.hasAttribute(date.attributes.def)){
				ddef=day.getAttribute(date.attributes.def)
				if(ddef=="t"){
					ddef=today.getDate()
				}
				else{
					ddef=parseInt(ddef)
				}
			}
			var isnull=false
			var htmld=""
			var htmlm=""
			var htmly=""
			var lan=date.getAttribute(date.attributes.ml) || date.getAttribute(date.attributes.rmn) || date.defaultValues.language
			date.set[id].lan=lan
			if(date.hasAttribute(id,date.attributes.empty)){
				htmld="<option value=''>"+date.language[lan][12]+"</option>"
				htmlm="<option value=''>"+date.language[lan][13]+"</option>"
				htmly="<option value=''>"+date.language[lan][14]+"</option>"
				isnull=true
			}
			var npd=false
			var nfd=false
			var mode="d"
			var dde=ddef
			var mde=mdef
			var yde=ydef
			if(year.hasAttribute(date.attributes.limit)){
				yde=year.getAttribute(date.attributes.limit)
				if(yde=="t"){
					yde=today.getFullYear()
				}
				else{
					yde=parseInt(yde)
				}
			}
			else if(yde==""){
				yde=ymi
			}
			if(month.hasAttribute(date.attributes.limit)){
				mde=month.getAttribute(date.attributes.limit)
				if(mde=="t"){
					mde=today.getMonth()+1
				}
				else{
					mde=parseInt(mde)
				}
			}
			else if(mde==""){
				mde=1
			}
			if(day.hasAttribute(date.attributes.limit)){
				dde=day.getAttribute(date.attributes.limit)
				if(dde[0]=="t"){
					dde=today.getDate()
				}
				else{
					dde=parseInt(dde)
				}
			}
			else if(dde==""){
				dde=1
			}
			var monthName=["1","2","3","4","5","6","7","8","9","10","11","12"]
			if(date.hasAttribute(id,date.attributes.ml)){
				var lan=date.getAttribute(id,date.attributes.ml)
				if(lan==""){
					monthName=date.language[date.defaultValues.language]
				}
				else{
					monthName=date.language[lan]
				}
			}
			else if(date.hasAttribute(id,date.attributes.tcml)){
				monthName=["01","02","03","04","05","06","07","08","09","10","11","12"]
			}
			var drmn=false
			var tcm=false
			var monthValues=["1","2","3","4","5","6","7","8","9","10","11","12"]
			if(date.hasAttribute(id,date.attributes.rmn)){
				drmn=true
				var lan=date.getAttribute(id,date.attributes.rmn)
				if(lan!=""){
					monthValues=date.language[lan]
				}
				else{
					if((date.hasAttribute(id,date.attributes.ml))&&(date.getAttribute(id,date.attributes.ml)!="")){
						lan=date.getAttribute(id,date.attributes.ml)
						monthValues=date.language[lan]
					}
					else{
						lan=date.defaultValues.language
						monthValues=date.language[lan]
					}
				}
				drmn=lan
			}
			else if(date.hasAttribute(id,date.attributes.tcm)){
				tcm=true
				monthValues=["01","02","03","04","05","06","07","08","09","10","11","12"]
			}
			var tcd=false
			var dayValues=["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
			if(date.hasAttribute(id,date.attributes.tcd)){
				tcd=true
				dayValues=["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
			}
			var dayNames=["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
			if(date.hasAttribute(id,date.attributes.tcdl)){
				dayNames=["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
			}
			var mmin=1
			var mmax=12
			var dmin=1
			var dmax=31
			if(date.hasAttribute(id,date.attributes.npd)){
				npd=true
				mode="p"
				ymi=yde
				if((ydef!="")&&(yde==ydef)){
					mmin=mde
					if((mdef!="")&&(mde==mdef)){
						var dpm=date.getDpmY(yde)
						dmax=dpm[mde]
						dmin=dde
					}
				}
			}
			else if(date.hasAttribute(id,date.attributes.nfd)){
				nfd=true
				mode="f"
				yma=yde
				if((ydef!="")&&(yde==ydef)){
					mmax=mde
					if((mdef!="")&&(mde==mdef)){
						var dpm=date.getDpmY(yde)
						if(dde>dpm[mde]){
							dmax=dpm[mde]
						}
						else{
							dmax=dde
						}
					}
				}
			}
			else if((ydef!="")&&(mdef!="")){
				var dpm=date.getDpmY(yde)
				dmax=dpm[mde]
			}
			
			var j=dmin
			var checked=""
			while(j<=dmax){
				if(j==ddef){
					checked=" selected"
				}
				else{
					checked=""
				}
				htmld+="<option value='"+dayValues[j-1]+"'"+checked+">"+dayNames[j-1]+"</option>"
				j++
			}
			j=mmin
			while(j<=mmax){
				if(j==mdef){
					checked=" selected"
				}
				else{
					checked=""
				}
				htmlm+="<option value='"+monthValues[j-1]+"'"+checked+">"+monthName[j-1]+"</option>"
				j++
			}
			var aob=1
			j=ymi
			if(date.hasAttribute(id,date.attributes.ry)){
				aob=-1
				j=yma
			}
			while((j<=yma)&&(j>=ymi)){
				if(j==ydef){
					checked=" selected"
				}
				else{
					checked=""
				}
				htmly+="<option value='"+j+"'"+checked+">"+j+"</option>"
				j+=aob
			}
			year.innerHTML=htmly
			month.innerHTML=htmlm
			day.innerHTML=htmld
			
			date.set[id].defaultDay=dde
			date.set[id].defaultMonth=mde
			date.set[id].defaultYear=yde
			
			var fonction=function(set){
				date.set[id].onChange=function(){
					var daypermonth=date.getDpm()
					var year=set.year.value
					var day=set.day.value
					var month=set.month.value
					if((set.drmn)&&(month!="")){
						var i=0
						var good=false
						while((i<date.language[set.drmn].length)&&(!good)){
							if(date.language[set.drmn][i]==month){
								month=i+1
								good=true
							}
							else{
								i++
							}
						}
					}
					else if((set.tcm)&&(month!="")){
						month=parseInt(month)
					}
					if(month!=""){
						if(date.isbissextile(year)){
							daypermonth[1]++
						}
					}
					else if(year==""){
						daypermonth[1]++
					}
					if((set.tcd)&&(day!="")){
						day=parseInt(day)
					}
					var htmlj=""
					var htmlm=""
					if(set.de){
						var l=date.defaultValues.language
						if(date.hasAttribute(set.id,date.attributes.ml)){
							l=date.getAttribute(set.id,date.attributes.ml)
						}
						htmlj+="<option value=''>"+date.language[set.lan][12]+"</option>"
						htmlm+="<option value=''>"+date.language[set.lan][13]+"</option>"
					}
					if(set.mode=="d"){
						if(month!==""){
							var dm=month
							var sm=1
							var mm=12
							if(day!==""){
								var dd=day
								var sd=1
								var md=daypermonth[month-1]
							}
							else{
								var dd=""
								var sd=1
								var md=daypermonth[month-1]
							}
						}
						else{
							var dm=""
							var sm=1
							var mm=12
							if(day!==""){
								var dd=day
								var sd=1
								var md=31
							}
							else{
								var dd=""
								var sd=1
								var md=31
							}
						}
					}
					else if(set.mode=="f"){
						if((year!=="")&&(year==set.defaultYear)){
							if(month!==""){
								if(month>=set.defaultMonth){
									var dm=set.defaultMonth
									var sm=1
									var mm=set.defaultMonth
									if(day!==""){
										if(day>=set.defaultDay){
											var dd=set.defaultDay
											var sd=1
											var md=set.defaultDay
										}
										else{
											var dd=day
											var sd=1
											var md=set.defaultDay
										}
									}
									else{
										var dd=""
										var sd=1
										var md=set.defaultDay
									}
								}
								else{
									var dm=month
									var sm=1
									var mm=set.defaultMonth
									if(day!==""){
										var dd=day
										var sd=1
										var md=daypermonth[month-1]
									}
									else{
										var dd=""
										var sd=1
										var md=daypermonth[month-1]
									}
								}
							}
							else{
								var dm=""
								var sm=1
								var mm=set.defaultMonth
								if(day!==""){
									var dd=day
									var sd=1
									var md=31
								}
								else{
									var dd=""
									var sd=1
									var md=31
								}
							}
						}
						else{
							if(month!==""){
								var dm=month
								var sm=1
								var mm=12
								if(day!==""){
									var dd=day
									var sd=1
									var md=daypermonth[month-1]
								}
								else{
									var dd=""
									var sd=1
									var md=daypermonth[month-1]
								}
							}
							else{
								var dm=""
								var sm=1
								var mm=12
								if(day!==""){
									var dd=day
									var sd=1
									var md=31
								}
								else{
									var dd=""
									var sd=1
									var md=31
								}
							}
						}
					}
					else if(set.mode=="p"){
						if((year!=="")&&(year==set.defaultYear)){
							if(month!==""){
								if(month<=set.defaultMonth){
									var dm=set.defaultMonth
									var sm=set.defaultMonth
									var mm=12
									if(day!==""){
										if(day<=set.defaultDay){
											var dd=set.defaultDay
											var sd=set.defaultDay
											var md=daypermonth[dm-1]
										}
										else{
											var dd=day
											var sd=set.defaultDay
											var md=daypermonth[dm-1]
										}
									}
									else{
										var dd=""
										var sd=set.defaultDay
										var md=daypermonth[dm-1]
									}
								}
								else{
									var dm=month
									var sm=set.defaultMonth
									var mm=12
									if(day!==""){
										var dd=day
										var sd=1
										var md=daypermonth[dm-1]
									}
									else{
										var dd=""
										var sd=1
										var md=daypermonth[dm-1]
									}
								}
							}
							else{
								var dm=""
								var sm=set.defaultMonth
								var mm=12
								if(day!==""){
									var dd=day
									var sd=1
									var md=31
								}
								else{
									var dd=""
									var sd=1
									var md=31
								}
							}
						}
						else{
							if(month!==""){
								var dm=month
								var sm=1
								var mm=12
								if(day!==""){
									var dd=day
									var sd=1
									var md=daypermonth[month-1]
								}
								else{
									var dd=""
									var sd=1
									var md=daypermonth[month-1]
								}
							}
							else{
								var dm=""
								var sm=1
								var mm=12
								if(day!==""){
									var dd=day
									var sd=1
									var md=31
								}
								else{
									var dd=""
									var sd=1
									var md=31
								}
							}
						}
					}
					
					var ml=false
					if(date.hasAttribute(set.id,date.attributes.ml)){
						ml=date.getAttribute(set.id,date.attributes.ml)
						if(ml==""){
							ml=date.defaultValues.language
						}
						var monthDisplays=date.language[ml]
					}
					else if(date.hasAttribute(set.id,date.attributes.tcml)){
						var monthDisplays=["01","02","03","04","05","06","07","08","09","10","11","12"]
					}
					else{
						var monthDisplays=["1","2","3","4","5","6","7","8","9","10","11","12"]
					}
					if(set.drmn!==false){
						var monthValues=date.language[set.drmn]
					}
					else if(set.tcm){
						var monthValues=["01","02","03","04","05","06","07","08","09","10","11","12"]
					}
					else{
						var monthValues=["1","2","3","4","5","6","7","8","9","10","11","12"]
					}
					if(set.tcd){
						var dayValues=["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
					}
					else{
						var dayValues=["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
					}
					var dayNames=["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
					if(date.hasAttribute(set.id,date.attributes.tcdl)){
						dayNames=["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"]
					}
					
					var checked=""
					while(sm<=mm){
						checked=""
						if(sm==dm){
							checked=" selected"
						}
						htmlm+="<option value='"+monthValues[sm-1]+"'"+checked+">"+monthDisplays[sm-1]+"</option>"
						sm++
					}
					while(sd<=md){
						checked=""
						if(sd==dd){
							checked=" selected"
						}
						htmlj+="<option value='"+dayValues[sd-1]+"'"+checked+">"+dayNames[sd-1]+"</option>"
						sd++
					}
					set.month.innerHTML=htmlm
					set.day.innerHTML=htmlj
				}
				var pf=date.searchParentForm(id)
				if(typeof(pf)!="undefined"){
					if(pf.hasAttribute(date.attributes.dor)){
						var dates=pf.getAttribute(date.attributes.dor).split(" ")
						var goood=true
						var z=0
						while((z<dates.length)&&(goood)){
							if(dates[z]==id){
								goood=false
							}
							z++
						}
						if(goood){
							pf.setAttribute(date.attributes.dor,pf.getAttribute(date.attributes.dor)+" "+id)
						}
					}
					else{
						pf.setAttribute(date.attributes.dor,id)
						pf.addEventListener("reset",function(){
							setTimeout(function(){
								date.reset(pf.getAttribute(date.attributes.dor))
							},1)
						})
					}
					
				}
			}
			fonction(date.set[id])
			
			date.set[id].mode=mode
			
			date.set[id].year.addEventListener("change",date.set[id].onChange)
			date.set[id].month.addEventListener("change",date.set[id].onChange)
			date.set[id].day.addEventListener("change",date.set[id].onChange)
			
			date.set[id].drmn=drmn
			date.set[id].tcd=tcd
			date.set[id].tcm=tcm
			date.set[id].de=isnull
			date.set[id].id=id
			date.setlistid.push(id)
		}
		i++
	}
}
date.searchParentForm=function(id){
	var day=date.set[id].year
	var forms=document.querySelectorAll("form")
	var i=0
	var elements=[]
	var j=0
	var ret=null
	while((i<forms.length)&&(ret===null)){
		elements=forms[i].querySelectorAll("select["+date.attributes.dy+"]")
		j=0
		while(j<elements.length){
			if(elements[j]==day){
				ret=forms[i]
			}
			j++
		}
		i++
	}
	if(ret!==null){
		return(ret)
	}
}
date.isset=function(id){
	return(typeof(date.set[id])!="undefined")
}
date.isbissextile=function(annee){
	return(new Date(annee,2,0).getDate()>=29)
}
date.searchMonthSelect=function(id){
	var months=date.months
	var i=0
	while(i<months.length){
		if(months[i].getAttribute(date.attributes.dm)==id){
			return(months[i])
		}
		i++
	}
}
date.searchDaySelect=function(id){
	var days=date.days
	var i=0
	while(i<days.length){
		if(days[i].getAttribute(date.attributes.dd)==id){
			return(days[i])
		}
		i++
	}
}
date.reset=function(id){
	if(id===undefined){
		var i=0
		var id=0
		while(i<date.setlistid.length){
			id=date.setlistid[i]
			date.set[id].day.removeEventListener("change",date.set[id].onChange)
			date.set[id].month.removeEventListener("change",date.set[id].onChange)
			date.set[id].year.removeEventListener("change",date.set[id].onChange)
			date.set[id]=undefined
			i++
		}
		date.set={}
		date.setlistid=[]
		date.init()
	}
	else{
		ids=id.split(" ")
		var i=0
		while(i<ids.length){
			if(date.isset(ids[i])){
				date.set[ids[i]].day.removeEventListener("change",date.set[ids[i]].onChange)
				date.set[ids[i]].month.removeEventListener("change",date.set[ids[i]].onChange)
				date.set[ids[i]].year.removeEventListener("change",date.set[ids[i]].onChange)
				date.set[ids[i]]=undefined
			}
			i++
		}
		var i=0
		var j=0
		var ret=[]
		var good=true
		while(i<date.setlistid.length){
			j=0
			good=true
			while((j<ids.length)&&(good)){
				if(date.setlistid[i]==ids[j]){
					good=false
				}
				j++
			}
			if(good){
				ret.push(date.setlistid[i])
			}
			i++
		}
		date.setlistid=ret
		date.init()
	}
}
date.delete=function(id){
	if(date.isset(id)){
		date.set[id].day.removeEventListener("change",date.set[id].onChange)
		date.set[id].month.removeEventListener("change",date.set[id].onChange)
		date.set[id].year.removeEventListener("change",date.set[id].onChange)
		date.set[id]=undefined
		var i=0
		var ret=[]
		while(i<date.setlistid.length){
			if(date.setlistid[i]!=id){
				ret.push(date.setlistid[i])
			}
			i++
		}
		date.setlistid=ret
	}
}
date.getValue=function(id,mode){
	if(date.isset(id)){
		var i=0
		var res=""
		var v=""
		while(i<mode.length){
			switch(mode[i]){
				case "d":
					if(date.set[id].day.value==""){
						return("")
					}
					v=date.set[id].day.value
					res+=parseInt(v)
					break
				case "D":
					if(date.set[id].day.value==""){
						return("")
					}
					v=parseInt(date.set[id].day.value)
					if(v<10){
						res+="0"+v
					}
					else{
						res+=v
					}
					break
				case "m":
					if(date.set[id].month.value==""){
						return("")
					}
					v=date.set[id].month.value
					if(typeof(date.set[id].drmn)=="string"){
						var j=0
						var l=date.language[date.set[id].drmn]
						var good=false
						var val=date.set[id].month.value
						while((j<l.length)&&(!good)){
							if(val==l[j]){
								good=true
								v=j+1
								res+=v
							}
							else{
								j++
							}
						}
					}
					else{
						res+=parseInt(date.set[id].month.value)
					}
					break
				case "M":
					if(date.set[id].month.value==""){
						return("")
					}
					v=date.set[id].month.value
					if(typeof(date.set[id].drmn)=="string"){
						var j=0
						var l=date.language[date.set[id].drmn]
						var good=false
						var val=date.set[id].month.value
						while((j<l.length)&&(!good)){
							if(val==l[j]){
								good=true
								v=j+1
							}
							else{
								j++
							}
						}
					}
					else{
						v=parseInt(v)
					}
					if(v<10){
						res+="0"+v
					}
					else{
						res+=v
					}
					break
				case "Y":
					if(date.set[id].year.value==""){
						return("")
					}
					res+=parseInt(date.set[id].year.value)
					break
				case "y":
					if(date.set[id].year.value==""){
						return("")
					}
					v=date.set[id].year.value
					res+=v.substr(v.length-2,2)
					break
				case "{":
					if(date.set[id].month.value==""){
						return("")
					}
					i++
					var lan=mode.substr(i,2)
					if(typeof(date.language[lan])=="undefined"){
						return("")
					}
					i+=2
					v=date.set[id].month.value
					if(typeof(date.set[id].drmn)=="string"){
						var j=0
						var l=date.language[date.set[id].drmn]
						var good=false
						var val=date.set[id].month.value
						while((j<l.length)&&(!good)){
							if(val==l[j]){
								good=true
								v=j
							}
							else{
								j++
							}
						}
					}
					else{
						v=parseInt(date.set[id].month.value)-1
					}
					res+=date.language[lan][v]
					break
				default:
					res+=mode[i]
					break
			}
			i++
		}
		return(res)
	}
	else{
		return(false)
	}
}
date.hasAttribute=function(id,attribute){
	if(date.isset(id)){
		return((date.set[id].day.hasAttribute(attribute))||(date.set[id].month.hasAttribute(attribute))||(date.set[id].year.hasAttribute(attribute)))
	}
	else{
		return(false)
	}
}
date.getAttribute=function(id,attribute){
	if(date.isset(id)){
		if(date.set[id].day.hasAttribute(attribute)){
			return(date.set[id].day.getAttribute(attribute))
		}
		else if(date.set[id].month.hasAttribute(attribute)){
			return(date.set[id].month.getAttribute(attribute))
		}
		else if(date.set[id].year.hasAttribute(attribute)){
			return(date.set[id].year.getAttribute(attribute))
		}
	}
}
date.getEmptyDay=function(){
	return({
		addEventListener:function(a,b){},
		removeEventListener:function(a,b){},
		innerHTML:"",
		hasAttribute:function(a,b){return(false)},
		getAttribute:function(a,b){return("")}
	})
}

date.init()

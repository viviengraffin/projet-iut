<script>
	var menu=document.querySelector("div.header-menu")
	var link=document.querySelector("div.header-title")
	link.innerHTML="<a href='./' class='header-title'>"+link.innerText+"</a>"
	var ul=menu.querySelector("ul")
	ul.classList.add("header-menu")
	var lis=ul.querySelectorAll("li")
	lis.forEach(function(li){
		li.classList.add("header-menu")
		li.querySelector("a").classList.add("header-menu")
	})
</script>

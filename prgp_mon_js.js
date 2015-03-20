// Version 1.0 Added on 12 Feb 2015
(function () {
	var ifrm = document.createElement('iframe');
	var adcall = document.getElementById('pgmad-inside');
	var params =  adcall.src.substring(adcall.src.lastIndexOf("?")+1);
	var cb = Math.floor(((Math.random() * 1000) * 1000)*1000);
	var s = getParameterByName('s',adcall.src); 
	var id =getParameterByName('id',adcall.src); 
	var floating = getParameterByName('f',adcall.src);
	var xmlhttp;
	var isWindowActive = true;
	var refreshInterval = 120000;
	var refreshId;
	var enableUserSync = true; 
	var pgCookie;
	
	function triggerRefresh(){
		adlink(); // To change ad immediately after comming window on focus 
		refreshId = setInterval(adlink,refreshInterval);
	}
	
	function stopRefresh(){
		  if(refreshId !== undefined){
			  clearInterval(refreshId);
		  }
    }
	
	function getParameterByName(name,params) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(params);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function adlink(){
		var ad = document.getElementById('mainframe');
		if(isWindowActive && isOnScreen(ad)){
			if(ad !== null){
				d.parentNode.removeChild(ad);
				d.parentNode.insertBefore(ifrm,d);
			}else{
				d.parentNode.insertBefore(ifrm,d);
			}
		}
	}
		
	function isOnScreen(element) {
	    var elementOffsetTop = parseInt(element.offsetTop);
	    var elementHeight = parseInt(element.height);
	    var screenScrollTop = parseInt(window.scrollY);
	    var screenHeight = parseInt(window.screen.availHeight);
	    var elementHalfHeight = Math.floor(elementHeight/2);
	    var scrollIsAboveElement = elementOffsetTop + elementHeight - elementHalfHeight - screenScrollTop >= 0;
	    var elementIsVisibleOnScreen = screenScrollTop + screenHeight - elementOffsetTop - elementHalfHeight >= 0;
	    return scrollIsAboveElement && elementIsVisibleOnScreen;
	}
	    
    function wfocus(){
    	isWindowActive = true;
    	if(refreshId !== undefined){
    		triggerRefresh();
		 }
    }
	
    function wBlur(){
    	if(refreshId !== undefined){
    		stopRefresh();
		 }
    	isWindowActive = false;
    }
    
    function ReadCookie(cookieName) {
    	 var theCookie=" "+document.cookie;
    	 var ind=theCookie.indexOf(" "+cookieName+"=");
    	 if (ind==-1) ind=theCookie.indexOf(";"+cookieName+"=");
    	 if (ind==-1 || cookieName=="") return "";
    	 var ind1=theCookie.indexOf(";",ind+1);
    	 if (ind1==-1) ind1=theCookie.length;
    	 return unescape(theCookie.substring(ind+cookieName.length+2,ind1));
    }

    function syncUser(){
    	if(enableUserSync){
    		pgCookie = ReadCookie("pg");
    		alert(pgCookie);
        	if(pgCookie){
        		var st = document.createElement('img');
                st.type = "text/javascript";
        		st.src =  "http://ib.adnxs.com/getuid?http://sync.personagraph.com:8090//pixel?pg_uuid="+pgCookie+"&adnxs_uid=$UID";
                document.body.appendChild(st);
        	}
    	}
    }
    
    function init(){
    	ifrm.src = 'http://ib.adnxs.com/tt?id='+ id + '&size='+s+'&cb='+cb;
		ifrm.async = true;
		ifrm.id = 'mainframe';
		ifrm.height = s.substring(s.indexOf('x')+1,s.length);
		ifrm.width = s.substring(0,s.indexOf('x'));
		ifrm.scrolling = 'no';
		ifrm.style.display = 'block';
		ifrm.style.margin = 'auto';
		ifrm.allowtransparency = 'true';
		if(floating == 1){
			ifrm.style.position = 'fixed';
			ifrm.style.bottom = '1px';
			ifrm.style.width = '100%';
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
	    {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		  {
			var obj = JSON.parse(xmlhttp.response);
			var flag = obj.settings[0][id];
			if(flag == 1){
				if(obj.settings[0]['refreshRate']){
					refreshInterval = obj.settings[0]['refreshRate'] * 1000;
				}
			   d.parentNode.insertBefore(ifrm,d);
			   triggerRefresh();
			}
		  }
		}
		xmlhttp.open("GET","http://an.pgm.personagraph.com/api/v1/appevent/placement?placementId="+id); // removed third parameter(false) to work as async call
		xmlhttp.send();
    }
	
	if (window.addEventListener) {
		window.addEventListener('focus', wfocus, false);
		window.addEventListener('blur', wBlur, false);
    } else if (window.attachEvent) {
    	window.attachEvent('onfocus', wfocus);
    	window.attachEvent('onblur', wBlur);
    }
    init();
    syncUser();
}());
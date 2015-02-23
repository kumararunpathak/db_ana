(function(){var ifrm=document.createElement('iframe');var adcall=document.getElementById('pgmad-inside');var params=adcall.src.substring(adcall.src.lastIndexOf("?")+1);var cb=Math.floor(((Math.random()*1000)*1000)*1000);var s=getParameterByName('s',adcall.src);var id=getParameterByName('id',adcall.src);var floating=getParameterByName('f',adcall.src);var xmlhttp;var isWindowActive=true;var refreshInterval=120000;var refreshId;function triggerRefresh(){adlink();refreshId=setInterval(adlink,refreshInterval);}
function stopRefresh(){if(refreshId!==undefined){clearInterval(refreshId);}}
function getParameterByName(name,params){name=name.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var regex=new RegExp("[\\?&]"+name+"=([^&#]*)"),results=regex.exec(params);return results===null?"":decodeURIComponent(results[1].replace(/\+/g," "));}
function adlink(){var ad=document.getElementById('mainframe');if(isWindowActive&&isOnScreen(ad)){if(ad!==null){d.parentNode.removeChild(ad);d.parentNode.insertBefore(ifrm,d);}else{d.parentNode.insertBefore(ifrm,d);}}}
function isOnScreen(element){var elementOffsetTop=parseInt(element.offsetTop);var elementHeight=parseInt(element.height);var screenScrollTop=parseInt(window.scrollY);var screenHeight=parseInt(window.screen.availHeight);var elementHalfHeight=Math.floor(elementHeight/2);var scrollIsAboveElement=elementOffsetTop+elementHeight-elementHalfHeight-screenScrollTop>=0;var elementIsVisibleOnScreen=screenScrollTop+screenHeight-elementOffsetTop-elementHalfHeight>=0;return scrollIsAboveElement&&elementIsVisibleOnScreen;}
function wfocus(){isWindowActive=true;if(refreshId!==undefined){triggerRefresh();}}
function wBlur(){if(refreshId!==undefined){stopRefresh();}
isWindowActive=false;}
function init(){ifrm.src='http://ib.adnxs.com/tt?id='+id+'&size='+s+'&cb='+cb;ifrm.async=true;ifrm.id='mainframe';ifrm.height=s.substring(s.indexOf('x')+1,s.length);ifrm.width=s.substring(0,s.indexOf('x'));ifrm.scrolling='no';ifrm.style.display='block';ifrm.style.margin='auto';ifrm.allowtransparency='true';if(floating==1){ifrm.style.position='fixed';ifrm.style.bottom='1px';ifrm.style.width='100%';}
if(window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else
{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4&&xmlhttp.status==200)
{var obj=JSON.parse(xmlhttp.response);var flag=obj.settings[0][id];if(flag==1){d.parentNode.insertBefore(ifrm,d);triggerRefresh();}
else if(flag==0){}}}
xmlhttp.open("GET","http://an.pgm.personagraph.com/api/v1/appevent/placement?placementId="+id);xmlhttp.send();}
if(window.addEventListener){window.addEventListener('focus',wfocus,false);window.addEventListener('blur',wBlur,false);}else if(window.attachEvent){window.attachEvent('onfocus',wfocus);window.attachEvent('onblur',wBlur);}
init();}());
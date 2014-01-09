/*
 * isim  : jQuery myDialog Plugin
 * sürüm : v1.0  (20 Ağustos 2010)
 * adres : http://www.eburhan.com/araclar/
 * yazar : Erhan BURHAN (eburhan)
 *
 * Telif Hakkı (c) 2010 eburhan
 * MIT ve GPL lisansları altında kullanılabilir
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function($){$.myDialog={overlayOpacity:0.6,overlayColor:'#000',overlayImage:true,alert:function(msg){$.myDialog._showOverlay();alert(msg);$.myDialog._hideOverlay();},confirm:function(msg){$.myDialog._showOverlay();var cvp=confirm(msg);$.myDialog._hideOverlay();return cvp;},prompt:function(msg,val){val=val||'';$.myDialog._showOverlay();var cvp=prompt(msg,val);$.myDialog._hideOverlay();return cvp;},_makeOverlay:function(){var _divObj=document.createElement('div');_divObj.id='myDialogOverlay';_divObj.style.position='absolute';_divObj.style.display='none';_divObj.style.zIndex=30300;_divObj.style.backgroundRepeat='repeat';document.getElementsByTagName('body')[0].appendChild(_divObj);},_showOverlay:function(){var _winObj=$(window);$('#myDialogOverlay').css({top:_winObj.scrollTop(),left:_winObj.scrollLeft(),width:_winObj.width(),height:_winObj.height(),display:'block',opacity:$.myDialog.overlayOpacity,backgroundColor:$.myDialog.overlayColor,backgroundImage:$.myDialog.overlayImage?'url(/themes/default/images/myDialog.png)':''});},_hideOverlay:function(){$('#myDialogOverlay').css('display','none');}};myDialog=function(o){if(o.image!=undefined)$.myDialog.overlayImage=o.image;if(o.color!=undefined)$.myDialog.overlayColor=o.color;if(o.opacity!=undefined)$.myDialog.overlayOpacity=o.opacity;};myAlert=function(msg){$.myDialog.alert(msg);};myConfirm=function(msg){return $.myDialog.confirm(msg);};myPrompt=function(msg,val){return $.myDialog.prompt(msg,val);};$($.myDialog._makeOverlay);})(jQuery);
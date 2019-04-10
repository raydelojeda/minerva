
var slideTime = 200;
var floatAtBottom = true;
//window.onload = function()
function initValidation()
{//alert("gg");
		var objForm = document.forms["frm"];
		objForm.nombre_destinatario.required = 1;
		objForm.nombre_remitente.required = 1;

		objForm.correo_detinatario.required = 1;
		objForm.correo_detinatario.regexp = "JSVAL_RX_EMAIL";

		objForm.correo_remitente.required = 1;
		objForm.correo_remitente.regexp = "JSVAL_RX_EMAIL";
}
function loadBar()
{
//alert("dddd");
  winOnResize(); // set initial position
  xAddEventListener(window, 'resize', winOnResize, false);
  xAddEventListener(window, 'scroll', winOnScroll, false);
  //if (document.getElementById('frm')){ initValidation(); }
}
function winOnResize() {
  xWidth('menu1', xClientWidth());
  winOnScroll(); // initial slide
}
function winOnScroll() {
  var y = xScrollTop();
  if (floatAtBottom) {
    y += xClientHeight() - xHeight('menu1');
  }
  if (xHeight('contenido1')<y)
  y = xHeight('contenido1') - xHeight('menu1') + 370;
  xSlideTo('menu1', 0, y+5, slideTime);
}

function xAddEventListener(e,eT,eL,cap){if(!(e=xGetElementById(e)))return;eT=eT.toLowerCase();if(e==window&&!e.opera&&!document.all){if(eT=='resize'){e.xPCW=xClientWidth();e.xPCH=xClientHeight();e.xREL=eL;xResizeEvent();return;}if(eT=='scroll'){e.xPSL=xScrollLeft();e.xPST=xScrollTop();e.xSEL=eL;xScrollEvent();return;}}if(e.addEventListener)e.addEventListener(eT,eL,cap);else if(e.attachEvent)e.attachEvent('on'+eT,eL);else e['on'+eT]=eL;}function xResizeEvent(){if(window.xREL)setTimeout('xResizeEvent()',250);var w=window,cw=xClientWidth(),ch=xClientHeight();if(w.xPCW!=cw||w.xPCH!=ch){w.xPCW=cw;w.xPCH=ch;if(w.xREL)w.xREL();}}function xScrollEvent(){if(window.xSEL)setTimeout('xScrollEvent()',250);var w=window,sl=xScrollLeft(),st=xScrollTop();if(w.xPSL!=sl||w.xPST!=st){w.xPSL=sl;w.xPST=st;if(w.xSEL)w.xSEL();}}function xClientHeight(){var v=0,d=document,w=window;if(d.compatMode=='CSS1Compat'&&!w.opera&&d.documentElement&&d.documentElement.clientHeight){v=d.documentElement.clientHeight;}else if(d.body&&d.body.clientHeight){v=d.body.clientHeight;}else if(xDef(w.innerWidth,w.innerHeight,d.width)){v=w.innerHeight;if(d.width>w.innerWidth)v-=16;}return v;}function xClientWidth(){var v=0,d=document,w=window;if(d.compatMode=='CSS1Compat'&&!w.opera&&d.documentElement&&d.documentElement.clientWidth){v=d.documentElement.clientWidth;}else if(d.body&&d.body.clientWidth){v=d.body.clientWidth;}else if(xDef(w.innerWidth,w.innerHeight,d.height)){v=w.innerWidth;if(d.height>w.innerHeight)v-=16;}return v;}function xDef(){for(var i=0;i<arguments.length;++i){if(typeof(arguments[i])=='undefined')return false;}return true;}function xGetComputedStyle(oEle,sProp,bInt){var s,p='undefined';var dv=document.defaultView;if(dv&&dv.getComputedStyle){s=dv.getComputedStyle(oEle,'');if(s)p=s.getPropertyValue(sProp);}else if(oEle.currentStyle){var i,c,a=sProp.split('-');sProp=a[0];for(i=1;i<a.length;++i){c=a[i].charAt(0);sProp+=a[i].replace(c,c.toUpperCase());}p=oEle.currentStyle[sProp];}else return null;return bInt?(parseInt(p)||0):p;}function xGetElementById(e){if(typeof(e)=='string'){if(document.getElementById)e=document.getElementById(e);else if(document.all)e=document.all[e];else e=null;}return e;}function xHeight(e,h){if(!(e=xGetElementById(e)))return 0;if(xNum(h)){if(h<0)h=0;else h=Math.round(h);}else h=-1;var css=xDef(e.style);if(e==document||e.tagName.toLowerCase()=='html'||e.tagName.toLowerCase()=='body'){h=xClientHeight();}else if(css&&xDef(e.offsetHeight)&&xStr(e.style.height)){if(h>=0){var pt=0,pb=0,bt=0,bb=0;if(document.compatMode=='CSS1Compat'){var gcs=xGetComputedStyle;pt=gcs(e,'padding-top',1);if(pt!==null){pb=gcs(e,'padding-bottom',1);bt=gcs(e,'border-top-width',1);bb=gcs(e,'border-bottom-width',1);}else if(xDef(e.offsetHeight,e.style.height)){e.style.height=h+'px';pt=e.offsetHeight-h;}}h-=(pt+pb+bt+bb);if(isNaN(h)||h<0)return;else e.style.height=h+'px';}h=e.offsetHeight;}else if(css&&xDef(e.style.pixelHeight)){if(h>=0)e.style.pixelHeight=h;h=e.style.pixelHeight;}return h;}function xLeft(e,iX){if(!(e=xGetElementById(e)))return 0;var css=xDef(e.style);if(css&&xStr(e.style.left)){if(xNum(iX))e.style.left=iX+'px';else{iX=parseInt(e.style.left);if(isNaN(iX))iX=xGetComputedStyle(e,'left',1);if(isNaN(iX))iX=0;}}else if(css&&xDef(e.style.pixelLeft)){if(xNum(iX))e.style.pixelLeft=iX;else iX=e.style.pixelLeft;}return iX;}xLibrary={version:'4.06',license:'GNU LGPL',url:'http://cross-browser.com/'};function xMoveTo(e,x,y){xLeft(e,x);xTop(e,y);}function xNum(){for(var i=0;i<arguments.length;++i){if(isNaN(arguments[i])||typeof(arguments[i])!='number')return false;}return true;}function xPageX(e){if(!(e=xGetElementById(e)))return 0;var x=0;while(e){if(xDef(e.offsetLeft))x+=e.offsetLeft;e=xDef(e.offsetParent)?e.offsetParent:null;}return x;}function xPageY(e){if(!(e=xGetElementById(e)))return 0;var y=0;while(e){if(xDef(e.offsetTop))y+=e.offsetTop;e=xDef(e.offsetParent)?e.offsetParent:null;}return y;}function xScrollLeft(e,bWin){var offset=0;if(!xDef(e)||bWin||e==document||e.tagName.toLowerCase()=='html'||e.tagName.toLowerCase()=='body'){var w=window;if(bWin&&e)w=e;if(w.document.documentElement&&w.document.documentElement.scrollLeft)offset=w.document.documentElement.scrollLeft;else if(w.document.body&&xDef(w.document.body.scrollLeft))offset=w.document.body.scrollLeft;}else{e=xGetElementById(e);if(e&&xNum(e.scrollLeft))offset=e.scrollLeft;}return offset;}function xScrollTop(e,bWin){var offset=0;if(!xDef(e)||bWin||e==document||e.tagName.toLowerCase()=='html'||e.tagName.toLowerCase()=='body'){var w=window;if(bWin&&e)w=e;if(w.document.documentElement&&w.document.documentElement.scrollTop)offset=w.document.documentElement.scrollTop;else if(w.document.body&&xDef(w.document.body.scrollTop))offset=w.document.body.scrollTop;}else{e=xGetElementById(e);if(e&&xNum(e.scrollTop))offset=e.scrollTop;}return offset;}function xShow(e){return xVisibility(e,1);}function xSlideTo(e,x,y,uTime){if(!(e=xGetElementById(e)))return;if(!e.timeout)e.timeout=25;e.xTarget=x;e.yTarget=y;e.slideTime=uTime;e.stop=false;e.yA=e.yTarget-xTop(e);e.xA=e.xTarget-xLeft(e);if(e.slideLinear)e.B=1/e.slideTime;else e.B=Math.PI/(2*e.slideTime);e.yD=xTop(e);e.xD=xLeft(e);var d=new Date();e.C=d.getTime();if(!e.moving)_xSlideTo(e);}function _xSlideTo(e){if(!(e=xGetElementById(e)))return;var now,s,t,newY,newX;now=new Date();t=now.getTime()-e.C;if(e.stop){e.moving=false;}else if(t<e.slideTime){setTimeout("_xSlideTo('"+e.id+"')",e.timeout);s=e.B*t;if(!e.slideLinear)s=Math.sin(s);newX=Math.round(e.xA*s+e.xD);newY=Math.round(e.yA*s+e.yD);xMoveTo(e,newX,newY);e.moving=true;}else{xMoveTo(e,e.xTarget,e.yTarget);e.moving=false;if(e.onslideend)e.onslideend();}}function xStr(s){for(var i=0;i<arguments.length;++i){if(typeof(arguments[i])!='string')return false;}return true;}function xTop(e,iY){if(!(e=xGetElementById(e)))return 0;var css=xDef(e.style);if(css&&xStr(e.style.top)){if(xNum(iY))e.style.top=iY+'px';else{iY=parseInt(e.style.top);if(isNaN(iY))iY=xGetComputedStyle(e,'top',1);if(isNaN(iY))iY=0;}}else if(css&&xDef(e.style.pixelTop)){if(xNum(iY))e.style.pixelTop=iY;else iY=e.style.pixelTop;}return iY;}function xVisibility(e,bShow){if(!(e=xGetElementById(e)))return null;if(e.style&&xDef(e.style.visibility)){if(xDef(bShow))e.style.visibility=bShow?'visible':'hidden';return e.style.visibility;}return null;}function xWidth(e,w){if(!(e=xGetElementById(e)))return 0;if(xNum(w)){if(w<0)w=0;else w=Math.round(w);}else w=-1;var css=xDef(e.style);if(e==document||e.tagName.toLowerCase()=='html'||e.tagName.toLowerCase()=='body'){w=xClientWidth();}else if(css&&xDef(e.offsetWidth)&&xStr(e.style.width)){if(w>=0){var pl=0,pr=0,bl=0,br=0;if(document.compatMode=='CSS1Compat'){var gcs=xGetComputedStyle;pl=gcs(e,'padding-left',1);if(pl!==null){pr=gcs(e,'padding-right',1);bl=gcs(e,'border-left-width',1);br=gcs(e,'border-right-width',1);}else if(xDef(e.offsetWidth,e.style.width)){e.style.width=w+'px';pl=e.offsetWidth-w;}}w-=(pl+pr+bl+br);if(isNaN(w)||w<0)return;else e.style.width=w+'px';}w=e.offsetWidth;}else if(css&&xDef(e.style.pixelWidth)){if(w>=0)e.style.pixelWidth=w;w=e.style.pixelWidth;}return w;}


/*******************************************************************************************************/

function validateCompleteForm(objForm,strErrorClass){
return _validateInternal(objForm,strErrorClass,0);
};
function validateStandard(objForm,strErrorClass){
return _validateInternal(objForm,strErrorClass,1);
};
function _validateInternal(form,strErrorClass,nErrorThrowType){
var strErrorMessage="";var objFirstError=null;
if(nErrorThrowType==0){
strErrorMessage=(form.err)?form.err:_getLanguageText("err_form");
};
var fields=_GenerateFormFields(form);
for(var i=0;i<fields.length;++i){
var field=fields[i];
if(!field.IsValid(fields)){
field.SetClass(strErrorClass);
if(nErrorThrowType==1){
_throwError(field);
return false;
}else{
if(objFirstError==null){
objFirstError=field;
}
strErrorMessage=_handleError(field,strErrorMessage);
bError=true;
}
}else{
field.ResetClass();
}
};
if(objFirstError!=null){
alert(strErrorMessage);
objFirstError.element.focus();
return false;
};
return true;
};
function _getLanguageText(id){
objTextsInternal=new _jsVal_Language();
objTexts=null;
try{
objTexts=new jsVal_Language();
}catch(ignored){};
switch(id){
case "err_form":strResult=(!objTexts||!objTexts.err_form)?objTextsInternal.err_form:objTexts.err_form;break;
case "err_enter":strResult=(!objTexts||!objTexts.err_enter)?objTextsInternal.err_enter:objTexts.err_enter;break;
case "err_select":strResult=(!objTexts||!objTexts.err_select)?objTextsInternal.err_select:objTexts.err_select;break;
};
return strResult;
};
function _GenerateFormFields(form){
var arr=new Array();
for(var i=0;i<form.length;++i){
var element=form.elements[i];
var index=_getElementIndex(arr,element);
if(index==-1){
arr[arr.length]=new Field(element,form);
}else{
arr[index].Merge(element)
};
};
return arr;
};
function _getElementIndex(arr,element){
if(element.name){
var elementName=element.name.toLowerCase();
for(var i=0;i<arr.length;++i){
if(arr[i].element.name){
if(arr[i].element.name.toLowerCase()==elementName){
return i;
}
};
};
}
return -1;
};
function _jsVal_Language(){
this.err_form="Por favor, escriba los valores de los campos:\n\n";
this.err_select="Please select a valid \"%FIELDNAME%\"";
this.err_enter="Please enter a valid \"%FIELDNAME%\"";
};
function Field(element,form){
this.type=element.type;
this.element=element;
this.exclude=element.exclude||element.getAttribute('exclude');
this.err=element.err||element.getAttribute('err');
this.required=_parseBoolean(element.required||element.getAttribute('required'));
this.realname=element.realname||element.getAttribute('realname');
this.elements=new Array();
switch(this.type){
case "textarea":
case "password":
case "text":
case "file":
this.value=element.value;
this.minLength=element.minlength||element.getAttribute('minlength');
this.maxLength=element.maxlength||element.getAttribute('maxlength');
this.regexp=this._getRegEx(element);
this.minValue=element.minvalue||element.getAttribute('minvalue');
this.maxValue=element.maxvalue||element.getAttribute('maxvalue');
this.equals=element.equals||element.getAttribute('equals');
this.callback=element.callback||element.getAttribute('callback');
break;
case "select-one":
case "select-multiple":
this.values=new Array();
for(var i=0;i<element.options.length;++i){
if(element.options[i].selected&&(!this.exclude||element.options[i].value!=this.exclude)){
this.values[this.values.length]=element.options[i].value;
}
}
this.min=element.min||element.getAttribute('min');
this.max=element.max||element.getAttribute('max');
this.equals=element.equals||element.getAttribute('equals');
break;
case "checkbox":
this.min=element.min||element.getAttribute('min');
this.max=element.max||element.getAttribute('max');
case "radio":
this.required=_parseBoolean(this.required||element.getAttribute('required'));
this.values=new Array();
if(element.checked){
this.values[0]=element.value;
}
this.elements[0]=element;
break;
};
};
Field.prototype.Merge=function(element){
var required=_parseBoolean(element.getAttribute('required'));
if(required){
this.required=true;
};
if(!this.err){
this.err=element.getAttribute('err');
};
if(!this.equals){
this.equals=element.getAttribute('equals');
};
if(!this.callback){
this.callback=element.getAttribute('callback');
};
if(!this.realname){
this.realname=element.getAttribute('realname');
};
if(!this.max){
this.max=element.getAttribute('max');
};
if(!this.min){
this.min=element.getAttribute('min');
};
if(!this.regexp){
this.regexp=this._getRegEx(element);
};
if(element.checked){
this.values[this.values.length]=element.value;
};
this.elements[this.elements.length]=element;
};
Field.prototype.IsValid=function(arrFields){
switch(this.type){
case "textarea":
case "password":
case "text":
case "file":
return this._ValidateText(arrFields);
case "select-one":
case "select-multiple":
case "radio":
case "checkbox":
return this._ValidateGroup(arrFields);
default:
return true;
};
};
Field.prototype.SetClass=function(newClassName){
if((newClassName)&&(newClassName!="")){
if((this.elements)&&(this.elements.length>0)){
for(var i=0;i<this.elements.length;++i){
if(this.elements[i].className!=newClassName){
this.elements[i].oldClassName=this.elements[i].className;
this.elements[i].className=newClassName;
}
}
}else{
if(this.element.className!=newClassName){
this.element.oldClassName=this.element.className;
this.element.className=newClassName;
}
};
}
};
Field.prototype.ResetClass=function(){
if((this.type!="button")&&(this.type!="submit")&&(this.type!="reset")){
if((this.elements)&&(this.elements.length>0)){
for(var i=0;i<this.elements.length;++i){
if(this.elements[i].oldClassName){
this.elements[i].className=this.elements[i].oldClassName;
}
else{
this.element.className="";
}
}
}else{
if(this.elements.oldClassName){
this.element.className=this.element.oldClassName;
}
else{
this.element.className="";
}
};
};
};
Field.prototype._getRegEx=function(element){
regex=element.regexp||element.getAttribute('regexp')
if(regex==null)return null;
retype=typeof(regex);
if(retype.toUpperCase()=="FUNCTION")
return regex;
else if((retype.toUpperCase()=="STRING")&&!(regex=="JSVAL_RX_EMAIL")&&!(regex=="JSVAL_RX_TEL")
&&!(regex=="JSVAL_RX_PC")&&!(regex=="JSVAL_RX_ZIP")&&!(regex=="JSVAL_RX_MONEY")
&&!(regex=="JSVAL_RX_CREDITCARD")&&!(regex=="JSVAL_RX_POSTALZIP"))
{
nBegin=0;nEnd=regex.length-1;
if(regex.charAt(0)=="/")nBegin=1;
if(regex.charAt(regex.length-1)=="/")nEnd=regex.length-2;
return new RegExp(regex.slice(nBegin,nEnd));
}
else{
return regex;
};
};
Field.prototype._ValidateText=function(arrFields){
if((this.required)&&(this.callback)){
nCurId=this.element.id?this.element.id:"";
nCurName=this.element.name?this.element.name:"";
eval("bResult = "+this.callback+"('"+nCurId+"', '"+nCurName+"', '"+this.value+"');");
if(bResult==false){
return false;
};
}else{
if(this.required&&!this.value){
return false;
};
if(this.value&&(this.minLength&&this.value.length<this.minLength)){
return false;
};
if(this.value&&(this.maxLength&&this.value.length>this.maxLength)){
return false;
};
if(this.regexp){
if(!_checkRegExp(this.regexp,this.value))
{
if(!this.required&&this.value){
return false;
}
if(this.required){
return false;
}
}
else
{
return true;
};
};
if(this.equals){
for(var i=0;i<arrFields.length;++i){
var field=arrFields[i];
if((field.element.name==this.equals)||(field.element.id==this.equals)){
if(field.element.value!=this.value){
return false;
};
break;
};
};
};
if(this.required){
var fValue=parseFloat(this.value);
if((this.minValue||this.maxValue)&&isNaN(fValue)){
return false;
};
if((this.minValue)&&(fValue<this.minValue)){
return false;
};
if((this.maxValue)&&(fValue>this.maxValue)){
return false
};
};
}
return true;
};
Field.prototype._ValidateGroup=function(arrFields){
if(this.required&&this.values.length==0){
return false;
};
if(this.required&&this.min&&this.min>this.values.length){
return false;
};
if(this.required&&this.max&&this.max<this.values.length){
return false;
};
return true;
};
function _handleError(field,strErrorMessage){
var obj=field.element;
strNewMessage=strErrorMessage+((field.realname)?field.realname:((obj.id)?obj.id:obj.name))+"\n";
return strNewMessage;
};
function _throwError(field){
var obj=field.element;
switch(field.type){
case "text":
case "password":
case "textarea":
case "file":
alert(_getError(field,"err_enter"));
try{
obj.focus();
}
catch(ignore){}
break;
case "select-one":
case "select-multiple":
case "radio":
case "checkbox":
alert(_getError(field,"err_select"));
break;
};
};
function _getError(field,str){
var obj=field.element;
strErrorTemp=(field.err)?field.err:_getLanguageText(str);
idx=strErrorTemp.indexOf("\\n");
while(idx>-1){
strErrorTemp=strErrorTemp.replace("\\n","\n");
idx=strErrorTemp.indexOf("\\n");
};
return strErrorTemp.replace("%FIELDNAME%",(field.realname)?field.realname:((obj.id)?obj.id:obj.name));
};
function _parseBoolean(value){
return !(!value||value==0||value=="0"||value=="false");
};
function _checkRegExp(regx,value){
switch(regx){
case "JSVAL_RX_EMAIL":
return((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/).test(value));
case "JSVAL_RX_TEL":
return((/^1?[\-]?\(?\d{3}\)?[\-]?\d{3}[\-]?\d{4}$/).test(value));
case "JSVAL_RX_PC":
return((/^[a-z]\d[a-z]?\d[a-z]\d$/i).test(value));
case "JSVAL_RX_ZIP":
return((/^\d{5}$/).test(value));
case "JSVAL_RX_MONEY":
return((/^\d+([\.]\d\d)?$/).test(value));
case "JSVAL_RX_CREDITCARD":
return(!isNaN(value));
case "JSVAL_RX_POSTALZIP":
if(value.length==6||value.length==7)
return((/^[a-zA-Z]\d[a-zA-Z] ?\d[a-zA-Z]\d$/).test(value));
if(value.length==5||value.length==10)
return((/^\d{5}(\-\d{4})?$/).test(value));
break;
default:
return(regx.test(value));
};
};

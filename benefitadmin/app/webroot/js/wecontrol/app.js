function loadPiece(href,divName,callBack) { 
   $('#loading_image').show(); 
    $(divName).load(href, {}, function(){ 
      $('#loading_image').hide();
        var divPaginationLinks = divName+" .ajaxlink a"; 
        $(divPaginationLinks).click(function() {      
            var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName); 
            return false; 
        });
  		if(typeof callBack === 'function') {
  			callBack();
  		}	  
    }); 
} 

function showMsg(msgType, msg){
  if(msgType == 'error'){
      $('#errorBox').text(msg).slideDown(300); 
  }else{
      $('#successBox').text(msg).slideDown(300);
  } 
  setTimeout(function(){
      $('#successBox').slideUp(300);
      $('#errorBox').slideUp(300);
  },6000); 
}

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}
jQuery.browser = browser;


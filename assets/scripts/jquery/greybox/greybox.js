/* Greybox Redux
 * jQuery required: http://jquery.com/
 * Written by: John Resig
 * Modified for SIMPATDA by: Lesmono Bayu Aji
 * License: GPL
 */

var GB_DONE = false;
var GB_HEIGHT = 400;
var GB_WIDTH = 400;

function GB_show(caption, url, height, width, scrolling,layer) {
  GB_LAYER = layer || 1;
  GB_HEIGHT = height || 400;
  GB_WIDTH = width || 400;
  if(!GB_DONE) {
  if (height == 500) {
    jQuery(document.body)
		  .append("<div id='GB_overlay"+GB_LAYER+"'></div><div id='GB_window"+GB_LAYER+"' style='top:40px'><div id='GB_caption'></div>"
        + "</div>");
  }
  else {
    jQuery(document.body)
		  .append("<div id='GB_overlay"+GB_LAYER+"'></div><div id='GB_window"+GB_LAYER+"'><div id='GB_caption'></div>"
        + "</div>");
  }
//       .append("<div id='GB_overlay'></div><div id='GB_window'><div id='GB_caption'></div>"
//         + "<img src='" + Drupal.settings.greybox.sitepath +"/images/close.gif' alt='Close window'/></div>");
//     jQuery("#GB_window img").click(GB_hide);
//     jQuery("#GB_overlay").click(GB_hide);

    jQuery(window).resize(GB_position);
		GB_DONE = true;
  }

  jQuery("#GB_frame").remove();
	scrolls = scrolling || 'yes';
  jQuery("#GB_window"+GB_LAYER).append("<iframe id='GB_frame' scrolling='"+scrolls+"' src='"+url+"'></iframe>");

  jQuery("#GB_caption").html(caption);
  jQuery("#GB_overlay"+GB_LAYER).show();
  GB_position(GB_LAYER);

  if(GB_ANIMATION)
    jQuery("#GB_window"+GB_LAYER).slideDown("slow");
  else
    jQuery("#GB_window"+GB_LAYER).show();
}

function GB_hide() {
  jQuery("#GB_window1,#GB_overlay1").hide();
}

function GB_show_again(layer) {
	jQuery('#admin').focus();
  jQuery("#GB_window"+layer+",#GB_overlay"+layer).show();
}

function GB_CURRENT_hide(layer) {
  GB_LAYER = layer || 1;
  jQuery("#GB_window"+GB_LAYER+",#GB_overlay"+GB_LAYER).hide();
}

function GB_position(layer) {
  GB_LAYER = layer || 1;
  var de = document.documentElement;
  var w = self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
  jQuery("#GB_window"+GB_LAYER).css({width:GB_WIDTH+"px",height:GB_HEIGHT+"px",
    left: ((w - GB_WIDTH)/2)+"px" });
  jQuery("#GB_frame").css("height",GB_HEIGHT - 32 +"px");
}

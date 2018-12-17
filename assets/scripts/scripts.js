jQuery(document).foundation();
/*
These functions make sure WordPress
and Foundation play nice together.
*/
jQuery(document).ready(function(){// Remove empty P tags created by WP inside of Accordion and Orbit
jQuery('.accordion p:empty, .orbit p:empty').remove();// Adds Flex Video to YouTube and Vimeo Embeds
jQuery('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').each(function(){if(jQuery(this).innerWidth()/jQuery(this).innerHeight()>1.5){jQuery(this).wrap("<div class='widescreen responsive-embed'/>");}else{jQuery(this).wrap("<div class='responsive-embed'/>");}});});

/*
Insert Custom JS Below
*/

(function($){

// Enables the submenu to be responsive by moving menu items into the More ... menu.
function updateSubMenu() {
	var $subnav1 = $('#menu-subnav-1');
	var $subnav2 = $('#menu-subnav-2');
	var $more = $subnav2.find('#more');
	var $moreSpan =$more.find('span');
	var $items1 = $subnav1.find('li');
	var $items2 = $subnav2.find('.more-ul li');
	var targetHeight = $items1.eq(0).height()*1.2;
	
	$more.hide();
	$items1.show();
	$items2.hide();
	$moreSpan.removeClass('selected');
	var i;
	for (i = $items1.length - 1; i >= 0; i--) {
	  if ($subnav1.height() > targetHeight) {
		$items1.eq(i).hide();
		$items2.eq(i).show();
		$more.show();
		if($items1.eq(i).hasClass('selected')){
			$moreSpan.addClass('selected');
		}
	  }
	}
  }
  
  updateSubMenu();
  
  $(window).on('resize', updateSubMenu);
}) (jQuery);

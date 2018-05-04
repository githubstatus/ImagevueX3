// jQuery File Tree Plugin
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// Visit http://abeautifulsite.net/notebook.php?article=58 for more information
//
// Usage: $('.fileTreeDemo').fileTree( options, callback )
//
// Options:  root           - root folder to display; default = /
//           script         - location of the serverside AJAX file to use; default = jqueryFileTree.php
//           folderEvent    - event to trigger expand/collapse; default = click
//           expandSpeed    - default = 500 (ms); use -1 for no animation
//           collapseSpeed  - default = 500 (ms); use -1 for no animation
//           expandEasing   - easing function to use on expand (optional)
//           collapseEasing - easing function to use on collapse (optional)
//           multiFolder    - whether or not to limit the browser to one subfolder at a time
//           loadMessage    - Message to display while initial tree loads (can be HTML)
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// TERMS OF USE
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//

if(jQuery) (function($){
	
	$.extend($.fn, {
		fileTree: function(o, h) {
			// Defaults
			if( !o ) var o = {};
			if( o.root == undefined ) o.root = '/';
			if( o.script == undefined ) o.script = 'jqueryFileTree.php';
			if( o.folderEvent == undefined ) o.folderEvent = 'click';
			if( o.expandSpeed == undefined ) o.expandSpeed= 500;
			if( o.collapseSpeed == undefined ) o.collapseSpeed= 500;
			if( o.expandEasing == undefined ) o.expandEasing = null;
			if( o.collapseEasing == undefined ) o.collapseEasing = null;
			if( o.multiFolder == undefined ) o.multiFolder = true;
			if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';

			$(this).each( function() {
				
				function showTree(c, t) {
                    if(t.search("%") >= 0)
                    {
                        var new_t = t.split("%");
                        var end = new_t.length - 1;
                        var n = -1;
                        new_t[end] = new_t[end].replace("/", "");
                        $.get("filemanager_js/utf-8.txt", function(data) {
                            var utf_8 = data.split('\n');
                            var new_utf_8 = "";
                            for(var i in new_t)
                            {
                                if(i > 0)
                                {
                                    for(var j in utf_8)
                                    {

                                        n = utf_8[j].indexOf(new_t[i]);
                                        if(n > -1)
                                        {
                                            new_utf_8 = utf_8[j].split(";");
                                            new_utf_8 = new_utf_8[1].split("\t")
                                            new_t[i] = new_utf_8[1];
                                        }
                                    }
                                }
                            }
                            new_t = new_t.join('');
                            t = new_t+"/";
                            $(c).addClass('wait');
                            $(".jqueryFileTree.start").remove();
                            $.post(o.script, { dir: t, sign: here }, function(data) {
                                $(c).find('.start').html('');
                                $(c).removeClass('wait').append(data);
                                if( o.root == t ) $(c).find('UL:hidden').show(); else $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
                                bindTree(c);
                            });
                        });
                    }
                    else
                    {
                        $(c).addClass('wait');
                        $(".jqueryFileTree.start").remove();
                        $.post(o.script, { dir: t, sign: here }, function(data) {
                            $(c).find('.start').html('');
                            $(c).removeClass('wait').append(data);
                            if( o.root == t ) $(c).find('UL:hidden').show(); else $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
                            bindTree(c);
                        });
                    }

				}

                function bindTree(t) {
                    $(t).find('LI A').bind(o.folderEvent, function() {
                        if( $(this).parent().hasClass('directory') ) {
                            if( $(this).parent().hasClass('collapsed') ) {
                                // Expand
                                if( !o.multiFolder ) {
                                    $(this).parent().parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
                                    $(this).parent().parent().find('LI.directory').removeClass('expanded').addClass('collapsed');
                                }
                                $(this).parent().find('UL').remove(); // cleanup
                                showTree( $(this).parent(), escape($(this).attr('rel').match( /.*\// )) );
                                $(this).parent().removeClass('collapsed').addClass('expanded');
                            } else {
                                // Collapse
                                $(this).parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
                                $(this).parent().removeClass('expanded').addClass('collapsed');
                            }
                        } else {
                            h($(this).attr('rel'));
                        }
                        return false;
                    });
                    // Prevent A from triggering the # on non-click events
                    if( o.folderEvent.toLowerCase != 'click' ) $(t).find('LI A').bind('click', function() { this_dir_selected = h($(this).attr('rel')); });

                }
				// Loading message
				$(this).html('<ul class="jqueryFileTree start"><li class="wait">' + o.loadMessage + '<li></ul>');
				// Get the initial file list
				showTree( $(this), escape(o.root) );
			});
		}
	});


    $.extend($.fn, {
        leftFileTree: function(o, h) {
            // Defaults
            if( !o ) var o = {};
            if( o.root == undefined ) o.root = '/';
            if( o.script == undefined ) o.script = 'folderMenu.php';
            if( o.folderEvent == undefined ) o.folderEvent = 'click';
            if( o.expandSpeed == undefined ) o.expandSpeed= 500;
            if( o.collapseSpeed == undefined ) o.collapseSpeed= 500;
            if( o.expandEasing == undefined ) o.expandEasing = null;
            if( o.collapseEasing == undefined ) o.collapseEasing = null;
            if( o.multiFolder == undefined ) o.multiFolder = true;
            if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';

            $(this).each( function() {

                function showTree(c, t) {
                    $(c).addClass('wait');
                    $(".jqueryFileTree.start").remove();
                    $.post(o.script, { dir: t, sign: here }, function(data) {
                        $(c).find('.start').html('');
                        $(c).removeClass('wait').append(data);
                        if( o.root == t ) $(c).find('UL:hidden').show(); else $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
                    });
                }

                if( first_flag == true )
                {
                    // Loading message
                    $(this).html('<ul class="jqueryFileTree start"><li class="wait">' + o.loadMessage + '<li></ul>');
                    // Get the initial file list
                    showTree( $(this), escape(o.root) );
                }

            });
        }
    });
	
})(jQuery);



var open_folders = new Array();
var repeat_flag = true;
var lick = true;
var open_all = true;
function fileTreeToggle( user, obj )
{
    if( lick ) {
        var c = "#left_folder_menu_box";
        if( !o ) var o = {};
        if( o.root == undefined ) o.root = '/';
        if( o.script == undefined ) o.script = user+'folderMenu.php';
        if( o.folderEvent == undefined ) o.folderEvent = 'click';
        if( o.expandSpeed == undefined ) o.expandSpeed= 100;
        if( o.collapseSpeed == undefined ) o.collapseSpeed= 100;
        if( o.expandEasing == undefined ) o.expandEasing = null;
        if( o.collapseEasing == undefined ) o.collapseEasing = null;
        if( o.multiFolder == undefined ) o.multiFolder = true;
        if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';
        liClick( $(c), o, obj );
    }
}

function liClick( c, o, lid )
{
    var id = "#"+$(c).attr("id");
    if( repeat_flag ) {
        repeat_flag = false;
        var tt = lid.id;
        if( lid.id != "FILEMANAGER_NO_COLLAPSE") {
            var t = document.getElementById(tt).getAttribute("rel");
            var hasChildren = document.getElementById(tt).getAttribute("data-children");
            var obj = lid;
            $(c).addClass('wait');
            $(".jqueryFileTree.start").remove();

            if( !in_array( open_folders,  lid.id ) ) {
                $.post(o.script, { dir: t, sign: here }, function(data) {
                    $(c).find('.start').html('');
                    $(c).removeClass('wait').append(data);
                    if( o.root == t ) {
                        $(c).find('UL:hidden').show();
                    }
                    else {
                        $("#"+tt+" ul").remove();
                        $(c).find('UL:hidden').appendTo("#"+tt);
                        $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
                        open_folders.push(lid.id);
                        $("#"+tt).addClass("expanded");
                        first_flag = $("#show_left_sidebar").html();
                        repeat_flag = true;
                    }
                    liBindTree( lid, o );
                });
            }
            else {
                $("#"+tt+" ul").remove();
                removeItem( open_folders, lid.id );
                $("#"+tt).removeClass("expanded");
                first_flag = $("#show_left_sidebar").html();
                setTimeout(function(){repeat_flag = true;}, 500);
            }
        }
    }
}

function liBindTree( t, o ) {
    $(t).bind(o.folderEvent, function() {
        first_flag = $("#show_left_sidebar").html();
    });
}



function liAutoOpen( c, o, lid )
{
    var id = "#"+$(c).attr("id");
    var go = true;
    if( go ) {
        repeat_flag = false;
        var tt = lid.id;
        if( lid.id != "FILEMANAGER_NO_COLLAPSE") {
            var t = document.getElementById(tt).getAttribute("rel");
            var hasChildren = document.getElementById(tt).getAttribute("data-children");
            var obj = lid;
            $(c).addClass('wait');
            $(".jqueryFileTree.start").remove();

            if( !in_array( open_folders,  lid.id ) ) {
                $.post(o.script, { dir: t, sign: here }, function(data) {
                    $(c).find('.start').html('');
                    $(c).removeClass('wait').append(data);
                    if( o.root == t ) {
                        $(c).find('UL:hidden').show();
                    }
                    else {
                        $("#"+tt+" ul").remove();
                        $(c).find('UL:hidden').appendTo("#"+tt);
                        $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
                        open_folders.push(lid.id);
                        $("#"+tt).addClass("expanded");
                        first_flag = $("#show_left_sidebar").html();
                        repeat_flag = true;
                    }
                    liBindTree( lid, o );
                });
            }
            else {
                $("#"+tt+" ul").remove();
                removeItem( open_folders, lid.id );
                $("#"+tt).removeClass("expanded");
                first_flag = $("#show_left_sidebar").html();
                setTimeout(function(){repeat_flag = true;}, 500);
            }
        }
    }
}


function open_all_dirs( user )
{		
		var expand = true;
    var obj = $(".left_open_all_dir");
    obj.children().each (function() {
        if( $(this).attr("data-class") != "" ) {
            $(this).addClass( $(this).attr("data-class") );
        }
        if( $(this).attr( "data-children" ) == "yes" && expand ) {
            var c = "#left_folder_menu_box";
            if( !o ) var o = {};
            if( o.root == undefined ) o.root = '/';
            if( o.script == undefined ) o.script = user+'folderMenu.php';
            if( o.folderEvent == undefined ) o.folderEvent = 'click';
            if( o.expandSpeed == undefined ) o.expandSpeed= 100;
            if( o.collapseSpeed == undefined ) o.collapseSpeed= 100;
            if( o.expandEasing == undefined ) o.expandEasing = null;
            if( o.collapseEasing == undefined ) o.collapseEasing = null;
            if( o.multiFolder == undefined ) o.multiFolder = true;
            if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';
            liAutoOpen( $(c), o, this );
            obj.removeClass( "left_open_all_dir" );
            setTimeout( function(){ open_all_dirs( user ) }, 1000, user );
        }
    });
}
window.onload = setTimeout( function(){ open_all_dirs( fileTreeUserFolder ) }, 1000, fileTreeUserFolder );

// setInterval
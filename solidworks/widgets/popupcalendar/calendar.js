// {{{ docs <-- this is a VIM (text editor) text fold

/**
 * Popup Calendar {VERSION}
 *
 * Summary: Popup Calendar is a date selector script that can be associated with
 *          an image next to a text form element that requires a date. The calendar
 *          pops up, at which point a date can be selected, and it will close the
 *          calendar and pass the date down to the input field. It has customizable
 *          colors and full year/month navigation. It works on all browsers (Konqueror,
 *          IE, Netscape 4, Mozilla, Opera) and makes choosing dates in forms much more
 *          pleasant.
 *
 * Maintainer: Dan Allen <dan@mojavelinux.com>
 *
 * License: LGPL - however, if you use this library, please post to my forum where you
 *          use it so that I get a chance to see my baby in action.  If you are doing
 *          this for commercial work perhaps you could send me a few Starbucks Coffee
 *          gift dollars to encourage future developement (NOT REQUIRED).  E-mail me
 *          for and address.
 *
 * Homepage: http://www.mojavelinux.com/forum/viewtopic.php?t=6
 *
 * Freshmeat Project: http://freshmeat.net/projects/popupcalendar/?topic_id=92
 *
 * Updated: {UPDATED}
 *
 * Supported Browsers: Mozilla (Gecko), IE 5+, Konqueror, Opera 7, Netscape 4
 *
 * Usage: 
 * Bascially, you need to pay attention to the paths and make sure
 * that the function getCalendar is looking in the right place for calendar.html,
 * which is the parent frame of calendar_body.html.  
 * 
 * The colors are configured as an associative array in the parent window.  I
 * haven't had a chance to document this yet, but you should be able to see what I
 * am going for in the calendar.js file.  All you have to do when calling
 * getCalendar is specify the full object to that form element, such as
 * 
 * return getCalendar(document.formName.elementName);
 * 
 * You will need to put killCalendar() in the body to make it go away if it is still open
 * when the page changes.
**/

// }}}
// {{{ settings (Editable)

var calendarWindow = null;
var calendarColors = new Array();
calendarColors['bgColor'] = '#BDC5D0';
calendarColors['borderColor'] = '#333366';
calendarColors['headerBgColor'] = '#143464';
calendarColors['headerColor'] = '#FFFFFF';
calendarColors['dateBgColor'] = '#8493A8';
calendarColors['dateColor'] = '#004080';
calendarColors['dateHoverBgColor'] = '#FFFFFF';
calendarColors['dateHoverColor'] = '#8493A8';
var calendarMonths = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
var calendarWeekdays = new Array('S', 'M', 'T', 'W', 'T', 'F', 'S', 'S');
var calendarUseToday = true;
var calendarFormat = 'm/d/y';
var calendarStartMonday = true;
var calendarScreenX = 100; // either 'auto' or numeric
var calendarScreenY = 100; // either 'auto' or numeric

// }}}
// {{{ getCalendar()

function getCalendar(in_dateField) 
{
    if (calendarWindow && !calendarWindow.closed) {
        alert('Calendar window already open.  Attempting focus...');
        try {
            calendarWindow.focus();
        }
        catch(e) {}
        
        return false;
    }

    var cal_width = 415;
    var cal_height = 310;

    // IE needs less space to make this thing
    if ((document.all) && (navigator.userAgent.indexOf("Konqueror") == -1)) {
        cal_width = 410;
    }

    calendarTarget = in_dateField;
    calendarWindow = window.open('../solidworks/widgets/popupcalendar/calendar.html', 'dateSelectorPopup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=0,dependent=no,width='+cal_width+',height='+cal_height + (calendarScreenX != 'auto' ? ',screenX=' + calendarScreenX : '') + (calendarScreenY != 'auto' ? ',screenY=' + calendarScreenY : ''));

    return false;
}

// }}}
// {{{ killCalendar()

function killCalendar() 
{
    if (calendarWindow && !calendarWindow.closed) {
        calendarWindow.close();
    }
}

// }}}

/*
 * @(#)install/javascript/password.js
 *
 *    Version: 0.50.20090325
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2009 by Yves Kreis
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */

function password(input) {
  if ('password-1' == input.name) {
    var password1 = input;
    var password2 = document.forms[0].elements['password-2'];
  } else if ('password-2' == input.name) {
    var password1 = document.forms[0].elements['password-1'];
    var password2 = input;
  } else {
    return;
  }
  
  if (!document.getElementById) {
    return;
  }
  
  if ('password-1' == input.name) {
    var level = strength(input.value);
    if (4 < level) {
      level = 4;
    }
    if ('' == input.value) {
      document.getElementById('idSMT').style.display = 'inline';
      level = -1;
    } else {
      document.getElementById('idSMT').style.display = 'none';
    }
    for (var block = 0; block <= 4; block++) {
      if (block <= level) {
        class = 'pwdChkCon' + level;
      } else {
        class = 'pwdChkCon';
      }
      document.getElementById('idSM' + block).className = class;
      if (block == level) {
        document.getElementById('idSMT' + block).style.display = 'inline';
      } else {
        document.getElementById('idSMT' + block).style.display = 'none';
      }
    }
  }
  
  result = document.getElementById('result');
  if (result == null) {
    return;
  }
  
  if ('' == password1.value && '' == password2.value) {
    result.innerHTML = '&nbsp;';
  } else if (password1.value == password2.value) {
    result.innerHTML = '<span style="color: green; font-weight: 700;">&radic;</span>';
  } else {
    result.innerHTML = '<span style="color: red; font-weight: 700;">&empty;</span>';
  }
}

function strength(password) {
  var strength = 0;
  
  // Length
  if (password.length < 10) {
    strength = strength + password.length;
  } else {
    strength = strength + 10;
  }
  
  // Letters
  if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
    strength = strength + 8;
  } else if (password.match(/[a-zA-Z]/)) {
    strength = strength + 5;
  }
  
  // Numbers
  if (password.match(/[0-9].*[0-9]/)) {
    strength = strength + 8;
  } else if (password.match(/[0-9]/)) {
    strength = strength + 5;
  }
  
  // Special Characters
  if (password.match(/[^a-zA-Z0-9].*[^a-zA-Z0-9]/)) {
    strength = strength + 8;
  } else if (password.match(/[^a-zA-Z0-9]/)) {
    strength = strength + 5;
  }
  
  // Combinations
  if (password.match(/[a-zA-Z]/) && password.match(/[0-9]/)) {
    strength = strength + 2;
  }
  if (password.match(/[a-zA-Z]/) && password.match(/[^a-zA-Z0-9]/)) {
    strength = strength + 2;
  }
  if (password.match(/[a-zA-Z]/) && password.match(/[0-9]/) && password.match(/[^a-zA-Z0-9]/)) {
    strength = strength + 2;
  }
  
  return (strength / 10) | 0;
}
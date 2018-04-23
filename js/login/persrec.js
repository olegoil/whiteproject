var userid = getCookie('suser');
var instid = getCookie('guser');
var userkey = getCookie('kuser');

var conn = new WebSocket('ws://138.201.188.138:12354');
var data;

function startWebsocket(websocketServerLocation) {
    conn = new WebSocket(websocketServerLocation);
    conn.onopen = function(e) {
      location.reload();
    };
    conn.onclose = function(){
        //try to reconnect in 5 seconds
        setTimeout(function(){startWebsocket(websocketServerLocation)}, 5000);
    };
}

conn.onopen = function(e) {

};

function sendtosocket() {
    conn.send(JSON.stringify({
      mem_id: "1"
    }));
};

conn.onerror = function(e) {
    // console.log('error: '+JSON.stringify(e))
};

conn.onclose = function() {
  startWebsocket('ws://138.201.188.138:12354');
}

function newsCount(site, prof) {
  setTimeout(function() {
    if(prof) {
      conn.send(JSON.stringify({
        mem_id: userid,
        inst_id: instid,
        mem_key: userkey,
        site_id: site,
        prof: prof
      }));
    }
    else {
      conn.send(JSON.stringify({
        mem_id: userid,
        inst_id: instid,
        mem_key: userkey,
        site_id: site
      }));
    }
  }, 200);
};

function setUser(l, m) {
  localStorage.setItem(l, m);
}

function getUser() {
  var x = localStorage.getItem("usr");
  return x;
}

function rmUser(w) {
  localStorage.removeItem(w);
}

// REVERSE HTMLENTITIES
var decodeEntities = (function() {
  // this prevents any overhead from creating the object each time
  var element = document.createElement('div');

  function decodeHTMLEntities (str) {
    if(str && typeof str === 'string') {
      // strip script/html tags
      str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
      str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
      element.innerHTML = str;
      str = element.textContent;
      element.textContent = '';
    }
    return str;
  }

  return decodeHTMLEntities;
})();

// var decodeEntities = function(str) {
//   return str.replace(/&#(\d+);/g, function(match, dec) {
//     return String.fromCharCode(dec);
//   });
// };

var encodeEntities = function(str) {
  var buf = [];
  for (var i=str.length-1;i>=0;i--) {
    buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
  }
  return buf.join('');
};

Notification.requestPermission();

// newsCount("main");
// newsCount("news");
// newsCount("event");
// newsCount("points");
// newsCount("push");
// newsCount("profile");
// newsCount("asks");
// newsCount("clients");
// newsCount("reviews");
// newsCount("statistics");

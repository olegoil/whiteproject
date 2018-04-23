function setCookie(cname) {
    var d = new Date();
    d.setTime(d.getTime() + (60*60*24*1000));
    var expires = "expires="+d.toUTCString()+';';
    document.cookie = cname + "=" + checkCookie(cname) + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function checkCookie(cookname) {

    if (!getCookie(cookname)) {
        window.location.href="../authorize/";
    }
    else {
        return getCookie(cookname);
    }

}

function logout() {
    document.cookie = "suser=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "guser=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "kuser=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    setTimeout(function() {window.location.href="../coms/logout.php";}, 1000);
}

if(checkCookie('suser') && checkCookie('guser') && checkCookie('kuser')) {
    // setCookie('suser');
    // setCookie('guser');
    // setCookie('kuser');
}
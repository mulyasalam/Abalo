// Überprüfen, ob der Benutzer bereits zugestimmt hat
function checkCookieConsent() {
    if (getCookie('cookieConsent') === 'true') {
        return true; // Der Benutzer hat bereits zugestimmt
    } else {
        return false; // Der Benutzer hat noch nicht zugestimmt
    }
}

// Anzeigen der Cookie-Zustimmungsabfrage
function showCookieConsent() {
    if (!checkCookieConsent()) {
        var consent = confirm("Wir verwenden Cookies, um Ihnen die bestmögliche Erfahrung auf unserer Website zu bieten. Sind Sie damit einverstanden?");
        if (consent) {
            setCookie('cookieConsent', 'true', 1); // Cookie für 1 Tage setzen
        }
    }
}

// Funktion zum Setzen eines Cookies
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Funktion zum Lesen eines Cookies
function getCookie(name) {
    var nameEQ = name + "=";
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) == 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}

// Anzeigen der Cookie-Zustimmungsabfrage beim Laden der Seite
showCookieConsent();

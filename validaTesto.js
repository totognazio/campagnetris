function validaTesto() {
var re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤€ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(testo_sms))) {
                return false;
        }

return true;
}

//@£$¥èéùìòÇØø ÅåΔ_ΦΓΛΩΠΨΣΘΞ^{}[~]|€ÆæßÉ !"#¤%&'()*+,-./<=>?¡§¿ ÄÖÑÜ äöñüà
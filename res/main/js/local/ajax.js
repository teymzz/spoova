/**
 * This converts ajax complete method's response to json format 
 * having success, error and message keys. The "complete" response returned 
 * is stored in json "message" key as either string or json format.
 * 
 * @param {*} response - xmlHttpRequest complete method's response
 */
function ajaxResponder(response) {
    var data = [];

    if (response.status === 200) {
        if (isJSON(response.responseText)) {
            data = { "success": "true", "type": "200", "message": JSON.parse(response.responseText) };
        } else {
            data = { "error": "parse error", "type": "response", "message": response.responseText };
        }
    } else {
        data = { "error": response.status+" error", "type": response.status, "message": response.responseText };
    }

    return data;
}


/**
 * This function is used to reformat a url supplied
 * 
 * @param {string} url The supplied url address
 */
function ajaxUri(url) {

    let online = (location.hostname != "localhost");
    let proUrl = window.location.pathname
    let proSplit = proUrl.split('/');
    let proBase = proSplit[1];
    let proBase2 = (proSplit.length > 2) ? proSplit[2] : '';
  
    proBase2 = (proBase2 != '') ? '/' + proBase2 : '';
    proBase += proBase2;
  
    let http = online ? 'https://' : 'http://' + location.host + '/';
  
    url = url || '';
    if (url != '') {
        url = urlenv(url);
        let newUrl = window.decodeURIComponent(url);
        newUrl = newUrl.trim().replace(/\s/g, '');
  
        if (/^(f|ht)tps?:\/\//i.test(newUrl)) {
            return `${newUrl}`;
        } else {
            if (online) {
                newUrl = newUrl.split('/')[1];
            }
            if (newUrl.charAt(0) == "/") newUrl = string.substring(1);
            return http + proBase + `/${newUrl}`;
        }
    }
    return false;
  
  }

/**
 * This function is used by ajaxUri to map urls function.
 * It is required by core functions and should not be removed
 * @param {string} $url http(s) protocol url (domain url)
 */
function urlenv($url) {

    let $urlext, $sp, $spl;

    if (typeof EXT == 'undefined') {
        EXT = '';
    }

    $urlext = EXT.toLowerCase();
    $url = $url.toString();
    $url = $url.split('?')[0].split("#")[0];
    $sp = $url.split('.');
    $spl = $sp.length;

    if (($spl === 1 || ($sp[0] === '' && $spl === 2)) && $urlext !== '') {
        $lastpop = $sp[0].split('/').pop() == '' ? 'index' : '';
        $url = $url + $lastpop + '.' + $urlext;
    }

    return $url;
}

const merge = (target) => {
  for (let i = 1, j = arguments.length; i < j; i++) {
    let source = arguments[i] || {};
    for (let prop in source) {
      if (source.hasOwnProperty(prop)) {
        let value = source[prop];
        if (value !== undefined) {
          target[prop] = value;
        }
      }
    }
  }

  return target;
}

const getCookie = (cname) => {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
        c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
    }
  }
  return "";
}

const setCookie = (cname, cvalue, extime = null) => {
  if(extime !== null){
    var d = new Date();
    d.setTime(d.getTime() + extime);
    var expires = "expires="+ d.toUTCString();

    document.cookie = cname + "=" + cvalue + ";" + expires ;
  }else{
    document.cookie = cname + "=" + cvalue;
  }    
}

const paginate_query_string = (data) => {
  if(data === null) return '';

  return '?per_page=' + data.per_page + '&current_page=' + data.current_page;
}

export { merge, getCookie, setCookie, paginate_query_string }
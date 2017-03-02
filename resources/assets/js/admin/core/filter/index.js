const urlParser = document.createElement('a')

export function domain (url) {
  urlParser.href = url
  return urlParser.hostname
}

export function count (arr) {
  return arr.length
}

export function prettyDate (date) {
  var a = new Date(date)
  return a.toDateString()
}

export function pluralize (val) {
	var args = Array.prototype.slice.call(arguments),
			singular = ' ' + args[1],
			plural = ' ' + (args.length > 2 ? args[2] : args[1] + 's');

  if (val === 1) {
    return val + singular;
  }

  return val + plural;
}

export function isActive(val){
  return val == 1 ? 'Yes' : 'No';
}

export function sex(val){
  return val === 'M' ? 'Male' : ( val === 'F' ? 'Female' : '' );
}

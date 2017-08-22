const options = {
  windowWidth: 600,
  windowHeight: 660
}

export function getOptions () {
  return options
}

export function openShareLink ($link) {
  const url = $link.attr('href')
  window.open(url, '_blank', `height=${options.windowHeight},width=${options.windowWidth},toolbar=false,location=false,menubar=false`)
}

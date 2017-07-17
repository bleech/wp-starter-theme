const options = {
  activeMenuClass: 'navigationMain-isActive'
}

export function getOptions () {
  return options
}

export function toggleActiveMenuClass ($container, $body, activeClass = options.activeMenuClass) {
  $container.toggleClass(activeClass)
  $body.toggleClass(activeClass)
}

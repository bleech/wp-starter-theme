/* globals Cookies */

import 'file-loader?name=vendor/js-cookie.js!js-cookie/src/js.cookie'

const options = {
  expireDays: 7,
  cookieName: 'cookies_accepted'
}

export function getOptions () {
  return options
}

export function acceptCookies (
  $container,
  cookieName = options.cookieName,
  expireDays = options.expireDays
) {
  Cookies.set(cookieName, true, {
    expires: expireDays
  })

  $container.remove()
}

export function checkCookies (
  $container,
  cookieName = options.cookieName
) {
  const cookiesAccepted = getCookieValue(cookieName)

  if (!cookiesAccepted) {
    $container.addClass('cookieNotification-isVisible')
  } else {
    $container.remove()
  }
}

function getCookieValue (cookieName) {
  return Cookies.get(cookieName)
}

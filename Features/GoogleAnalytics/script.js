/* global dataFlyntFeatureGoogleAnalytics, Cookies */

import 'file-loader?name=vendor/js-cookie.js!js-cookie/src/js.cookie'

const data = dataFlyntFeatureGoogleAnalytics

export function optOut () {
  let confirmOptout = false

  if (data.confirm) {
    confirmOptout = window.confirm(data.confirm)
  } else {
    confirmOptout = true
  }

  if (confirmOptout) {
    window['ga-disable-' + data.gaId] = true
    if (data.success) {
      window.alert(data.success)
    }
    setOptoutCookie()
  }
}

export function isOptout () {
  return getOptoutCookie()
}

function setOptoutCookie () {
  Cookies.set('disableGa', true)
}

function getOptoutCookie () {
  return Cookies.get('disableGa')
}

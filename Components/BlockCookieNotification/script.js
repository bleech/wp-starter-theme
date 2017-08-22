import $ from 'jquery'

import * as acceptButton from './Partials/AcceptButton/script'

class BlockCookieNotification extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    return self
  }

  connectedCallback () {
    this.$.on('click', '.acceptButton', (e) => {
      e.preventDefault()
      acceptButton.acceptCookies(this.$)
    })
    acceptButton.checkCookies(this.$)
  }
}

window.customElements.define('flynt-block-cookie-notification', BlockCookieNotification, {extends: 'div'})

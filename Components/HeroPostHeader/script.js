import $ from 'jquery'
import * as Share from './Partials/Share/script'

class HeroPostHeader extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {

  }

  connectedCallback () {
    this.$.on('click', '.share-link', this.sharePost)
  }

  sharePost = (e) => {
    e.preventDefault()
    Share.openShareLink($(e.currentTarget))
  }
}

window.customElements.define('flynt-hero-post-header', HeroPostHeader, {extends: 'div'})

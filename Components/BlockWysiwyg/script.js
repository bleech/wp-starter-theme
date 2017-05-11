class BlockWysiwyg extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$element = $('.element', this)
  }

  connectedCallback () {
    console.log('module BlockWysiwyg connected', this)
  }
}

window.customElements.define('flynt-block-wysiwyg', BlockWysiwyg, {extends: 'div'})

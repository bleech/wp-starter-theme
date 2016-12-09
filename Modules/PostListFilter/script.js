// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'

class PostListFilter extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.filters = {
      'category': '',
      'tag': ''
    }

    this.$categoryFilter = $('.postFilter-categoryFilter', this)
    this.$tagFilter = $('.postFilter-tagFilter', this)
  }

  connectedCallback () {
    this.$categoryFilter.on('change', this.changeFilter.bind(this))
    this.$tagFilter.on('change', this.changeFilter.bind(this))
  }

  changeFilter (e) {
    const $el = $(e.currentTarget)
    const target = $el.val()
    if (target.length) {
      window.location = $el.val()
    }
  }
}

window.customElements.define('wps-post-list-filter', PostListFilter, {extends: 'div'})

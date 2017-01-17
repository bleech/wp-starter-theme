class Oembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.oembed-posterImage', this)
    this.$video = $('.oembed-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.$posterImage.addClass('oembed-posterImage-isHidden')
    this.$video.addClass('oembed-video-isVisible')
  }
}

window.customElements.define('wps-oembed', Oembed, {extends: 'div'})

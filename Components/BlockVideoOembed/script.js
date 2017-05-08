class BlockVideoOembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.resolveOembedVideoElements()
  }

  connectedCallback () {
    this.connectedOembedVideoCallback()
  }

  resolveOembedVideoElements () {
    this.$posterImage = $('.oembedVideo-posterImage', this)
    this.$video = $('.oembedVideo-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedOembedVideoCallback () {
    this.$iframe.on('load', this.onIframeLoad.bind(this))
    this.$posterImage.on('click', (e) => {
      this.setIframeSrc()
    })
  }

  setIframeSrc = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
  }

  onIframeLoad () {
    this.$video.addClass('oembedVideo-video-isVisible')
    this.$posterImage.addClass('oembedVideo-posterImage-isHidden')
  }
}

window.customElements.define('flynt-block-video-oembed', BlockVideoOembed, {extends: 'div'})

class MediaTextBlock extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.mediaTextBlock-oembedPosterImage', this)
    this.$video = $('.mediaTextBlock-oembedVideo', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    let iframeSrc = this.$iframe.attr('src')

    if (iframeSrc.split('?').length <= 1) {
      iframeSrc += '?'
    }
    const autoplay = iframeSrc + '&autoplay=1'

    this.$posterImage.addClass('isHidden')
    this.$video.addClass('isActive')
    this.$iframe.attr('src', autoplay)
  }
}

window.customElements.define('wps-media-text-block', MediaTextBlock, {extends: 'div'})

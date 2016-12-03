// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
// Webpack looks for dist file in package "main".
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

import slickConfiguration from './sliderConfiguration.js'

class MediaSlider extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$mediaSlides = $('.mediaSlider-slides', this)
    this.$posterImage = $('.mediaSlider-oembedPosterImage', this)
    this.$oembedVideo = $('.mediaSlider-oembedVideo iframe', this)
    this.$slides = $('.mediaSlider-slide', this)
  }

  connectedCallback () {
    this.setupSlider()
    this.$posterImage.on('click', this.startVideo.bind(this))
  }

  setupSlider = () => {
    if (this.$slides.length > 1) {
      this.$mediaSlides.slick(slickConfiguration)
    }
  }

  startVideo = (e) => {
    const $el = $(e.currentTarget)
    const $currentSlide = $el.closest('.mediaSlider-slide')
    const $currentVideo = $currentSlide.find('iframe')
    let iframeSrc = $currentVideo.attr('src')

    if (iframeSrc.split('?').length <= 1) {
      iframeSrc += '?'
    }

    $el.addClass('mediaSlider-oembedPosterImage-isHidden')
    $currentVideo.attr('src', iframeSrc + '&autoplay=true')
  }
}

window.customElements.define('wps-media-slider', MediaSlider, {extends: 'div'})

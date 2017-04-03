// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!csso-loader!normalize.css/normalize.css'
// Webpack looks for dist file in package "main".
import 'file-loader?name=vendor/slick.js!slick-carousel/slick/slick.min'
import 'file-loader?name=vendor/slick.css!csso-loader!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

import slickConfiguration from './sliderConfiguration.js'

class SliderMedia extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$mediaSlides = $('.sliderMedia-slides', this)
    this.$posterImage = $('.sliderMedia-oembedPosterImage', this)
    this.$oembedVideo = $('.sliderMedia-oembedVideo iframe', this)
    this.$slides = $('.sliderMedia-slide', this)
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
    const $currentPosterImage = $(e.target)
    let $iframe =
      $(e.target)
      .closest('.sliderMedia-oembedVideoContainer')
      .find('iframe')
    const iframeSrc = $iframe.data('src')
    $iframe.attr('src', iframeSrc)
    $currentPosterImage.addClass('sliderMedia-oembedPosterImage-isHidden')
  }
}

window.customElements.define('flynt-slider-media', SliderMedia, {extends: 'div'})

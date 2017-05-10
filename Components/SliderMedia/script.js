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
    this.$sliderMedia = $('.sliderMedia', this)
    this.$slideTitle = $('.slideTitle', this)
    this.$mediaSlides = $('.sliderMedia-slides', this)
    this.$slides = $('.sliderMedia-slide', this)
    this.$posterImage = $('.oembedVideo-posterImageWrapper', this)
    this.$oembedVideo = $('.oembedVideo-video iframe', this)
  }

  connectedCallback () {
    this.setupSlider()
    this.$oembedVideo.on('load', this.onIframeLoad.bind(this))
    this.$posterImage.on('click', this.setIframeSrc.bind(this))
  }

  setupSlider = () => {
    if (this.$slides.length > 1) {
      this.$mediaSlides.on('init', this.slickInit.bind(this))
      this.$mediaSlides.slick(slickConfiguration)
      this.$mediaSlides.on('beforeChange', this.unsetIframeSrc.bind(this))
    }
  }

  slickInit = () => {
    this.$sliderMedia.removeClass('sliderMedia-isHidden')
  }

  unsetIframeSrc (event, slick, currentSlide, nextSlide) {
    let $currentSlide = $(slick.$slides[currentSlide])
    $currentSlide.find('iframe').attr('src', '')
  }

  setIframeSrc = (e) => {
    let $oembedVideo = $(e.target).closest('.oembedVideo')
    let $iframe = $oembedVideo.find('iframe')
    const iframeSrc = $iframe.data('src')
    $iframe.attr('src', iframeSrc)
  }

  onIframeLoad = (e) => {
    let $iframe = $(e.target)
    let $oembedVideo = $iframe.closest('.oembedVideo')
    let $video = $oembedVideo.find('.oembedVideo-video')
    let $posterImage = $oembedVideo.find('.oembedVideo-posterImageWrapper')

    if ($iframe.attr('src')) {
      // show video
      $video.addClass('oembedVideo-video-isVisible')
      $posterImage.addClass('oembedVideo-posterImageWrapper-isHidden')
      if(this.$slideTitle.hasClass('slideTitle--overlayTitleTop') || this.$slideTitle.hasClass('slideTitle--overlayTitleBottom')) {
        this.$slideTitle.addClass('slideTitle-isHidden')
      }
    } else {
      // hide video
      $video.removeClass('oembedVideo-video-isVisible')
      $posterImage.removeClass('oembedVideo-posterImageWrapper-isHidden')
      this.$slideTitle.removeClass('slideTitle-isHidden')
    }
  }
}

window.customElements.define('flynt-slider-media', SliderMedia, {extends: 'div'})

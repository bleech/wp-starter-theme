/* globals google */

import $ from 'jquery'
import 'file-loader?name=vendor/jquery-throttle-debounce.js!jquery-throttle-debounce/jquery.ba-throttle-debounce'
import * as MapsHelper from './helper'

/* You can use https://mapstyle.withgoogle.com/ to style your map for your needs */
import mapStyles from './json/mapstyles.json'

class MapGoogle extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    this.setOptions()
    return self
  }

  resolveElements () {
    this.$wrapper = $('.map-wrapper', this)
  }

  connectedCallback () {
    const apiKey = this.$.data('key')
    this.location = MapsHelper.getLocationFromContainer(this.$wrapper)
    this.markerIcon = this.$wrapper.data('marker')
    this.infoContent = JSON.parse(this.$wrapper.data('content'))

    window.FlyntExternalScriptLoader.getInstance().initialize('googleMaps', {
      apiKey
    })
    .then(() => {
      this.initMap()
    })
  }

  apiIsLoaded () {
    window.GoogleMapsAPIIsLoaded = true
    this.initMap()
  }

  initMap () {
    $(window).on('resize', $.debounce(250, this.redrawMap))
    this.initGoogleMap()
    this.initGoogleMarker()
    this.initInfoWindow()

    this.infoWindow.open(this.map, this.marker)
  }

  redrawMap = () => {
    MapsHelper.resetMap(this.location, this.map)
  }

  initGoogleMap () {
    this.gmapSettings = MapsHelper.assignMapsSettings(this.location, this.mapSettings, mapStyles)
    this.map = new google.maps.Map(this.$wrapper.get(0), this.gmapSettings)
  }

  initGoogleMarker () {
    this.markerSettings = MapsHelper.assignMarkerSettings(this.location, this.markerSettings, this.map)
    this.markerSettings = MapsHelper.setMarkerIcon(this.markerSettings, this.markerIcon, 32, 32)

    this.marker = new google.maps.Marker(this.markerSettings)
  }

  initInfoWindow () {
    if (this.infoContent) {
      this.infoWindow = MapsHelper.addInfoWindowToMarker(this.infoContent, this.marker, this.map)
    }
  }

  setOptions () {
    this.mapSettings = {
      'clickableIcons': false,
      'disableDefaultUI': true,
      'disableDoubleClickZoom': true,
      'draggable': true,
      'fullscreenControl': false,
      'heading': 0,
      'keyboardShortcuts': false,
      'panControl': false,
      'rotateControl': false,
      'scaleControl': false,
      'scrollwheel': false,
      'streetViewControl': false,
      'tilt': 0,
      'zoomControl': false
    }

    this.markerSettings = {
      'draggable': false
    }
  }
}

window.customElements.define('flynt-map-google', MapGoogle, {extends: 'div'})

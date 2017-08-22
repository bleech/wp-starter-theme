/* globals google */

/**
 * Concatenates default settings and user-defined settings to one object for use in maps object
 * @param  {object} location    [object containing latitude, longitude and zoom value]
 * @param  {object} mapSettings [google maps api configuration object]
 * @param  {object} mapStyles   [google maps styling configuration object]
 * @return {object}             [concatenated object with all options]
 */
export function assignMapsSettings (location, mapSettings, mapStyles) {
  Object.assign(mapSettings, {
    scrollwheel: false,
    styles: mapStyles,
    center: {
      lat: location.lat,
      lng: location.lng
    },
    zoom: location.zoom
  })

  return mapSettings
}

/**
 * Concatenates default settings and user-defined settings to one object for use in marker object
 * @param  {object} location        [object containing lat and lang value]
 * @param  {object} markerSettings  [google maps api marker configuration object]
 * @param  {object} map             [google maps object]
 * @return {object}                 [concatenated object with all options]
 */
export function assignMarkerSettings (location, markerSettings, map) {
  Object.assign(markerSettings, {
    position: {
      lat: location.lat,
      lng: location.lng
    },
    map: map
  })

  return markerSettings
}

/**
 * Adds a icon object to the passed markerSettings
 * @param {object} markerSettings   Contains the already set settings for this type of marker
 * @param {string} iconUrl          Contains the absolute URL to the marker icon
 * @param {Number} [scaledSizeX=16] Scaled width for the new icon
 * @param {Number} [scaledSizeY=16] Scaled height for the new icon
 */
export function setMarkerIcon (markerSettings, iconUrl, scaledSizeX = 16, scaledSizeY = 16) {
  Object.assign(markerSettings, {
    'icon': {
      'url': iconUrl,
      'scaledSize': new google.maps.Size(scaledSizeX, scaledSizeY),
      'origin': new google.maps.Point(0, 0),
      'anchor': new google.maps.Point(scaledSizeX / 2, scaledSizeY / 2)
    }
  })

  return markerSettings
}

/**
 * Adds a Google Maps Info Window to a marker
 * @param {string} content  [HTML content for the marker]
 * @param {object} marker   [Google maps marker object]
 * @param {object} map      [Google maps map object]
 * @return {object}         [Google maps info window object]
 */
export function addInfoWindowToMarker (content, marker, map) {
  const infoWindow = new google.maps.InfoWindow({
    content: content
  })

  marker.addListener('click', () => {
    infoWindow.open(map, marker)
  })

  return infoWindow
}

/**
 * Resets a google map to a certain location
 * @param {object} location [object containing lat and lang values]
 * @param {object} map      [google maps object]
 */
export function resetMap (location, map) {
  map.setCenter({
    lat: location.lat,
    lng: location.lng
  })

  map.setZoom(location.zoom)
}

/**
 * Returns location of a container containing lat, lng and zoom values in data-attributes
 * @param  {object} $container [jQuery object of the container]
 * @return {object}            [object containing lat, lng and zoom values]
 */
export function getLocationFromContainer ($container) {
  return {
    'lat': parseFloat($container.data('lat')),
    'lng': parseFloat($container.data('lng')),
    'zoom': parseFloat($container.data('zoom'))
  }
}

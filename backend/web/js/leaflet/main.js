var map = L.map('map');
var wpSource = [];
var control;

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

initRoute = function (start, end, ingorePrevious=false) {
  var previousVal = $('#routewrapper-waypoints').val();
  if (previousVal)
    var os = JSON.parse(previousVal);

  if (os !== undefined && os != null && !ingorePrevious) {
    for (var i = 0; i < os.waypoints.length; i++)
      wpSource[i] = L.latLng(os.waypoints[i][0], os.waypoints[i][1]);
  } else {
    if (control !== undefined && control.getWaypoints().length > 0) {
      control.spliceWaypoints(0, control.getWaypoints().length);
      wpSource = [];
    }
    if (start == undefined && end == undefined) {
      wpSource.push(L.latLng(37.97, 58.31));
      wpSource.push(L.latLng(37.91, 58.44));
    } else {
      wpSource.push(L.latLng(start.lat, start.lng));
      wpSource.push(L.latLng(end.lat, end.lng));
    }
  }

  control = L.Routing.control(L.extend(window.lrmConfig, {
    waypoints: wpSource,
    geocoder: L.Control.Geocoder.nominatim(),
    routeWhileDragging: true,
    reverseWaypoints: false,
    showAlternatives: false,
    // createMarker: function (i, wp, total) {
    //   if (i > 0 && i < (total-1))
    //     return null;
    //   else {
    //     var options = {
    //         draggable: this.draggableWaypoints
    //       },
    //       marker = L.marker(wp.latLng, options);
    //     return marker;
    //   }
    // },
    altLineOptions: {
      styles: [
        {color: 'black', opacity: 0.15, weight: 9},
        {color: 'white', opacity: 0.8, weight: 6},
        {color: 'blue', opacity: 0.5, weight: 2}
      ]
    }
  })).addTo(map);

  L.Routing.errorControl(control).addTo(map);
}
// initRoute();


$('#save_waypoints').on('click', function (e) {
  e.preventDefault();
  e.stopPropagation(true);

  var data = {};
  var w = [], wp;
  wp = control.getWaypoints();
  for (var i = 0; i < wp.length; i++) {
    w[i] = [wp[i].latLng.lat, wp[i].latLng.lng]
  }
  data.waypoints = w;
  var str = JSON.stringify(data);
  $('#routewrapper-waypoints').val(str);
  return false;
});





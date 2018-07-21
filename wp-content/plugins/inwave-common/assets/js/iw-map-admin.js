/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
google.maps.visualRefresh = true;
(function ($) {
    $.fn.iwMap = function (options) {

        $(this).each(function () {
            if ($(this).hasClass('map-rendered')) {
                return;
            }
            $(this).addClass('map-rendered');
            this.map = null;
            this.marker = null;
            this.geocoder = new google.maps.Geocoder();


            this.renderMap = function () {
                var mapObj = this;
                mapObj.map = new google.maps.Map($(this).find('.map-preview').get(0), options);

                mapObj.marker = new google.maps.Marker({
                    map: mapObj.map,
                    position: mapObj.map.getCenter(),
                    animation: google.maps.Animation.DROP,
                    draggable: true
                });
                google.maps.event.addListener(this.marker, 'dragend', function () {
                    var latlng = mapObj.marker.getPosition();
                    mapObj.map.setCenter(latlng);
                    mapObj.billDataToForm(latlng);
                });
                google.maps.event.addListener(this.map, 'click', function (res) {
                    var latlng = new google.maps.LatLng(res.latLng.lat(), res.latLng.lng());
                    mapObj.marker.setPosition(latlng);
                    mapObj.map.setCenter(latlng);
                    mapObj.billDataToForm();
                });
                google.maps.event.addListener(this.map, 'zoom_changed', function () {
                    mapObj.billDataToForm();
                });
            };

            this.billDataToForm = function () {
                var center = this.map.getCenter(),
                zoomlv = this.map.getZoom(),
                data = {zoomlv:zoomlv, lat:center.lat(),  lng:center.lng()};
                $('.infunding-map input.iw-map').val(JSON.stringify(data));
            };

            this.renderMap();
        });
    };

})(jQuery);
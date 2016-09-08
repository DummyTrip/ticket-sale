/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';
app.factory('UploadService', ['$q', function($q){
    return{
        uploadImage: function (image) {
            var xhr = new XMLHttpRequest();
            var form = new FormData();

            form.append('img', image, image.name);
            form.append('description', 'hard coded description'); // TODO: it is required for image upload in answer

            xhr.upload.addEventListener('progress', function(e) {
                console.log('progress: ', e);
            });

            xhr.onload = function(e) {
                console.log('succesfully uploaded');
            };

            xhr.onerror = function(err) {
                console.log('error: ', err);
            };

            xhr.onabort = function() {
              console.log('upload is aborted');
            };

            xhr.open('POST', $rootScope.api_url + '/test', true);
            xhr.send(form);
            return null;
        }

    };
}]);
function getFirstKey(data) {
    for (var prop in data)
        if (data.propertyIsEnumerable(prop))
            return prop;
}

var recordApp = angular.module('recordApp', [])
var recordViewer = angular.module('recordViewer', []);

recordApp.controller('recordController', function ($scope, $http) {

    $http.get("/record/types/").success(function(response) {
        $scope.typeOptions = response;
        $scope.typeOption = getFirstKey($scope.typeOptions);
    });

    $scope.switchType = function() {
        //get the fields that belong to this record type!
        $http.get("/record/" + document.getElementById('record_type').options[document.getElementById('record_type').selectedIndex].innerHTML + "/fields").success(function(response) {
            return $scope.fields = response;
        });
    }



});

recordViewer.controller('recordViewerController', function($scope, $http) {

    var d = document.getElementById('record_list');
    if (d.children.length > 0) {
        var id = d.children[0].getAttribute('data-id');

        $http.get("/record/" + id + "/json/").success(function(response) {
            $scope.record_content = response;
        }).error(function(data, status, headers, config) {
            $scope.record_content = {};
        });

        $scope.updateRecordContent = function(record_id) {

            $http.get("/record/" + record_id + "/json/").success(function(response) {
                $scope.record_content = response;
            }).error(function(data, status, headers, config) {
                return $scope.record_content = [{record_name:"Oops! There was an error retrieving the selected record: " + data}];
            });

        }
    }
});

//    .factory('fetchFields', function($http) {
//
//        return {
//            // get all the fields for this record type
//            get : function() {
//                var type = document.getElementById('record_type').value;
//                return $http.get('/record/type/options/' + type);
//            }
//        }
//
    //});

//recordSwitcher.controller('recordCtrl', function($scope, $http, recordSwitcher) {
//    // object to hold all the data for the new comment form
//    $scope.fields = {};
//
//    // loading variable to show the spinning loading icon
//    $scope.loading = true;
//
//    // function to handle switching option
//    //
//    $scope.switchOption = function() {
//        $scope.loading = true;
//
//        // save the comment. pass in comment data from the form
//        // use the function we created in our service
//        recordSwitcher.get($scope.fetchFields)
//            .success(function(data) {
//
//                // if successful, we'll need to refresh the fields
//                recordSwitcher.get()
//                    .success(function(getData) {
//                        $scope.fields = getData;
//                        $scope.loading = false;
//                    });
//
//            })
//            .error(function(data) {
//                console.log(data);
//            });
//    };
//   });

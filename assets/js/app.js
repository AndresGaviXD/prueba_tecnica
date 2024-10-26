
angular.module('myApp', [])
.controller('ProductController', function($scope, $http) {
    $scope.products = [];
    $scope.categories = [];
    $scope.showForm = false;
    $scope.editMode = false;
    $scope.product = {};

    // Obtener categorías y productos
    $http.get('api/category.php').then(response => $scope.categories = response.data);
    $http.get('api/product.php').then(response => $scope.products = response.data);

    // Guardar producto
    $scope.saveProduct = function() {
        if ($scope.editMode) {
            $http.put('api/product.php', $scope.product).then(() => refreshData());
        } else {
            $http.post('api/product.php', $scope.product).then(() => refreshData());
        }
        $scope.showForm = false;
        $scope.editMode = false;
    };

    // Editar producto
    $scope.editProduct = function(product) {
        $scope.product = angular.copy(product);
        $scope.showForm = true;
        $scope.editMode = true;
    };

    // Eliminar producto con confirmación
    $scope.deleteProduct = function(id) {
        if (confirm("¿Estás seguro de eliminar este producto?")) {
            $http.delete(`api/product.php?id=${id}`).then(() => refreshData());
        }
    };

    // Cancelar edición o creación
    $scope.cancel = function() {
        $scope.product = {};
        $scope.showForm = false;
        $scope.editMode = false;
    };

    // Actualizar la lista de productos
    function refreshData() {
        $http.get('api/product.php').then(response => $scope.product = response.data);
    }
});

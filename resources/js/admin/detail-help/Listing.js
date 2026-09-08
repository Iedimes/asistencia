import AppListing from '../app-components/Listing/AppListing';

Vue.component('detail-help-listing', {
    mixins: [AppListing],
    data: function() {
        return {
            filters: {
                tecnico: ''
            }
        };
    },
    methods: {
        deleteItem: function deleteItem(url) {
            var _this7 = this;

            this.$modal.show('dialog', {
                title: 'Confirmar Eliminación',
                text: '¿Desea eliminar esta atención técnica?',
                buttons: [{ title: 'Cancelar' }, {
                    title: 'Sí, borrar',
                    handler: function handler() {
                        _this7.$modal.hide('dialog');
                        axios.delete(url).then(function (response) {
                            _this7.loadData();
                            _this7.$notify({ type: 'success', title: '¡Éxito!', text: response.data.message ? response.data.message : 'Registro eliminado correctamente.' });
                        }, function (error) {
                            _this7.$notify({ type: 'error', title: '¡Error!', text: error.response.data.message ? error.response.data.message : 'Ha ocurrido un error.' });
                        });
                    }
                }]
            });
        },

    }
});


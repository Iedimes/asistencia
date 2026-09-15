import AppListing from '../app-components/Listing/AppListing';

Vue.component('help-listing', {
    mixins: [AppListing],
    props: {
        autoRefreshInterval: {
            type: Number,
            default: 0
        }
    },
    data: function() {
        return {
            filters: {
                tecnico: ''
            },
            refreshTimer: null
        };
    },
    mounted: function() {
        var _this = this;
        if (this.autoRefreshInterval && this.autoRefreshInterval > 0) {
            this.refreshTimer = setInterval(function() {
                _this.loadData();
            }, this.autoRefreshInterval);
        }
    },
    beforeDestroy: function() {
        if (this.refreshTimer) {
            clearInterval(this.refreshTimer);
        }
    },
    methods: {
        deleteItem: function deleteItem(url) {
            var _this7 = this;

            this.$modal.show('dialog', {
                title: 'Confirmar Eliminación',
                text: '¿Está seguro de que desea eliminar esta asistencia técnica?',
                buttons: [{ title: 'Cancelar' }, {
                    title: 'Sí, borrar',
                    handler: function handler() {
                        _this7.$modal.hide('dialog');
                        axios.delete(url).then(function (response) {
                            _this7.loadData();
                            _this7.$notify({ type: 'success', title: '¡Éxito!', text: response.data.message ? response.data.message : 'Asistencia eliminada correctamente.' });
                        }, function (error) {
                            _this7.$notify({ type: 'error', title: '¡Error!', text: error.response.data.message ? error.response.data.message : 'Ha ocurrido un error.' });
                        });
                    }
                }]
            });
        },

    }
});


import AppListing from '../app-components/Listing/AppListing';

Vue.component('funcionario-listing', {
    mixins: [AppListing],
    data: function data() {
        return {
            orderBy: {
                column: 'FuncNro',
                direction: 'asc'
            },
        }
    },
});

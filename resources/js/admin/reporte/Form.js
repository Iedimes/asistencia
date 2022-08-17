import AppForm from '../app-components/Form/AppForm';

Vue.component('reporte-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                inicio:  '' ,
                fin:  '' ,
                user_id:  '' ,
                
            }
        }
    }

});
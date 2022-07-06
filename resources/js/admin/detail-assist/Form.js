import AppForm from '../app-components/Form/AppForm';

Vue.component('detail-assist-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                id_assist:  '' ,
                id_user:  '' ,
                id_state:  '' ,
                solution:  '' ,
                date:  '' ,
                
            }
        }
    }

});
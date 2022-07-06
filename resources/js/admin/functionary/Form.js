import AppForm from '../app-components/Form/AppForm';

Vue.component('functionary-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                ci:  '' ,
                full_name:  '' ,
                user_name:  '' ,
                
            }
        }
    }

});
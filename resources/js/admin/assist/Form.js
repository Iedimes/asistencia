import AppForm from '../app-components/Form/AppForm';

Vue.component('assist-form', {
    mixins: [AppForm],
    props:['state'],
    data: function() {
        return {
            form: {
                heritage:  '' ,
                id_user:  '' ,
                date:  '' ,
                id_state:  '' ,
                id_category:  '' ,

            }
        }
    }

});

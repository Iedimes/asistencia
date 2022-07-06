import AppForm from '../app-components/Form/AppForm';

Vue.component('detail-help-form', {
    mixins: [AppForm],
    props:['help', 'state', 'category', 'user'],
    data: function() {
        return {
            form: {
                help_id:  this.help ,
                user:  '' ,
                state: '' ,
                solution:  '' ,
                date:  '' ,
                category:  '' ,
                patrimony:  '' ,

            }
        }
    }

});

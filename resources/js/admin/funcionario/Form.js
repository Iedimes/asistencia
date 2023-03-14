import AppForm from '../app-components/Form/AppForm';

Vue.component('funcionario-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                FuncNro:  '' ,
                FuncNom:  '' ,
                FUsuCod:  '' ,
                
            }
        }
    }

});
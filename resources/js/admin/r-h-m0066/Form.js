import AppForm from '../app-components/Form/AppForm';

Vue.component('r-h-m0066-form', {
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
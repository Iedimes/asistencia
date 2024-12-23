import AppForm from '../app-components/Form/AppForm';

Vue.component('detail-help-form', {
    mixins: [AppForm],
    props: ['help', 'state', 'category', 'user'],
    data: function () {
        return {
            form: {
                help_id: this.help,
                user: '',
                state: '',
                solution: '',
                date: '',
                category: '',
                patrimony: '',
            }
        };
    },
    methods: {
        handleInput(event) {
            const textarea = event.target;
            const cursorPosition = textarea.selectionStart;

            // Actualiza el modelo con el texto en mayúsculas
            this.form.solution = textarea.value.toUpperCase();

            // Restaura la posición del cursor
            this.$nextTick(() => {
                textarea.setSelectionRange(cursorPosition, cursorPosition);
            });

            // Valida después de actualizar
            this.validate(event);
        },
        validate(event) {
            // Lógica de validación si es necesaria
        }
    }
});

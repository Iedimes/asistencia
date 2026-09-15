import AppForm from '../app-components/Form/AppForm';

Vue.component('detail-help-form', {
    mixins: [AppForm],
    props: ['help', 'state', 'category', 'user'],
    data: function () {
        const now = new Date();
        const pad = (n) => String(n).padStart(2, '0');
        const nowString = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;

        return {
            form: {
                help_id: this.help,
                user: '',
                state: '',
                solution: '',
                date: nowString,
                category: '',
                patrimony: '',
            }
        };
    },
    mounted() {
        if (!this.form.date) {
            const now = new Date();
            const pad = (n) => String(n).padStart(2, '0');
            this.form.date = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        }
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

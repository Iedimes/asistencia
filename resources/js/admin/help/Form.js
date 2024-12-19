import AppForm from '../app-components/Form/AppForm';

Vue.component('help-form', {
    mixins: [AppForm],
    props: ['finddataurl'],
    data: function () {
        return {
            show: false,
            ticket: '',
            requiresDocuments: false, // Estado para el checkbox
            form: {
                ci: '',
                name: '',
                user: '',
                dependency: '',
                fone: '',
                problem: '',
            },
            mediaCollections: ['gallery'],
        };
    },
   methods: {
    onSuccess: function (data) {
        if (data.showTicketModal) {
            // Mostrar el modal solo si `showTicketModal` es true
            this.$modal.show('dialog', {
                title: 'Importante!',
                text: 'Ticket N° <strong>' + data.ticket + '</strong> generado correctamente!!!',
                buttons: [
                    {
                        title: '<span class="btn-dialog btn-primary">Aceptar.<span>',
                        handler: () => {
                            this.$modal.hide('dialog');
                            window.location.replace(data.redirect);
                        },
                    },
                ],
            });
        } else {
            // Redirigir directamente
            window.location.replace(data.redirect);
        }
        this.submiting = false;
    },
    findData: function () {
        axios
            .get(this.finddataurl + "/" + this.form.ci)
            .then(response => {
                if (!response.data.error) {
                    this.form.name = response.data.cedula.FuncNom;
                    this.form.user = response.data.cedula.FUsuCod;
                    this.form.dependency = response.data.cedula.dpto.DepenDes;
                    this.form.dependency_id = response.data.cedula.dpto.DepenCod;
                } else {
                    this.form.name = '';
                    this.form.user = '';
                    this.form.dependency = '';
                    this.errorcedula = 'Cédula no se encuentra en base de datos';
                    this.$notify({ type: 'error', title: 'Error!', text: 'Cédula no se encuentra en base de datos' });
                }
            })
            .catch(error => {
                console.log(error);
                this.form.name = '';
                this.form.user = '';
                this.form.dependency = '';
                this.$notify({ type: 'error', title: 'Error buscando datos', text: error });
            });
    },
    toggleUploader() {
        this.requiresDocuments = !this.requiresDocuments;
    },
},

});

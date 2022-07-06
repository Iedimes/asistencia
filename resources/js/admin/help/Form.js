import AppForm from '../app-components/Form/AppForm';

Vue.component('help-form', {
    mixins: [AppForm],
    props:['finddataurl'],
    data: function() {
        return {
            show: false,
            ticket: '',
            form: {
                ci:  '' ,
                name:  '' ,
                user:  '' ,
                dependency:  '' ,
                fone:  '' ,
                problem:  '' ,
            }
        }
    },
    methods: {
        onSuccess: function onSuccess(data) {


            this.$modal.show('dialog', {
                title: 'Importante!',
                text: 'Ticket N° <strong>'+ data.ticket + '</strong> generado correctamente!!!',
                buttons: [
                    //{ title: 'No, cancel.' },
                    {
                        title: '<span class="btn-dialog btn-primary">Aceptar.<span>',
                        handler: () => {
                            this.$modal.hide('dialog');
                            window.location.replace(data.redirect);
                            console.log('deleted');
                        }
                    }
                ]
            });
            this.submiting = false;

            console.log(data);
            //this.form.ci = ''
            //this.form.name = ''
            //this.form.user = ''
            //this.form.dependency = ''
            //this.form.fone = ''
            //this.form.problem = ''
            //this.show = true
            //this.$notify({ type: 'success', title: 'IMPORTANTE',position:"top center", width:"200px", duration: 10000, text: 'El ticket '+data.ticket+' ha sido creado correctamente!!!'});
            if (data.redirect) {

              //console.log(data.message);
              //this.show = true
              this.ticket = data.ticket
            }
          },
        findData: function () {

            axios
                .get(this.finddataurl + "/" + this.form.ci)
                .then(response => {
                   console.log(response.data)
                    if (!response.data.error) {
                        this.errorcedula = '';
                        this.form.name = response.data.cedula.FuncNom;
                        this.form.user = response.data.cedula.FUsuCod;
                        this.form.dependency = response.data.cedula.dpto.DepenDes;
                        this.form.dependency_id = response.data.cedula.dpto.DepenCod;

                    } else {

                        console.log('No funciona')
                        this.form.name = '';
                        this.form.user = '';
                        this.form.dependency = '';
                        this.form.dependency_id = '';
                        this.errorcedula = 'Cedula no se encuentra en base de datos';
                        this.$notify({ type: 'error', title: 'Error!', text:'Cedula no se encuentra en base de datos' });
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    this.form.name = '';
                    this.form.user = '';
                    this.form.dependency = '';
                    this.form.dependency_id = '';
                    this.$notify({ type: 'error', title: 'Error buscando datos', text: error });
                })

        },
        onCancel: function () {
            console.log('User cancelled the loader.')
        }
    },


});

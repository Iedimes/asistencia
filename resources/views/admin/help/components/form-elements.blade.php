<!-- Campo Cédula de Identidad -->
<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('ci'), 'has-success': fields.ci && fields.ci.valid }">
    <label title="Ingrese el número de cédula de la persona que va a solicitar la asistencia" for="ci" class="col-form-label fw-bold text-dark text-start text-md-start" style="color: #1e293b;" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">
        <i class="fa fa-id-card text-primary me-1"></i> Cédula de Identidad <span class="text-danger">*</span>
    </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <input onkeypress="return pulsar(event)" @change="findData" type="text" v-model="form.ci" @input="validate($event)" class="form-control shadow-sm text-dark font-weight-bold" style="border: 1px solid #cbd5e1; color: #0f172a;" id="ci" name="ci" placeholder="Ingrese Nro. de Cédula y presione Enter o Tab">
        <div v-if="errors.has('ci')" class="form-control-feedback form-text text-danger font-weight-bold" v-cloak>@{{ errors.first('ci') }}</div>
    </div>
</div>

<script type="text/javascript">
    function pulsar(e) {
      tecla = (document.all) ? e.keyCode : e.which;
      return (tecla != 13);
    }
</script>

<!-- Campo Nombre Completo -->
<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label fw-bold text-dark text-start text-md-start" style="color: #1e293b;" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">
        <i class="fa fa-user text-primary me-1"></i> Nombre Completo
    </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <input readonly type="text" v-model="form.name" @input="validate($event)" class="form-control shadow-sm font-weight-bold text-dark" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #0f172a !important;" id="name" name="name" placeholder="Nombre autocompletado automáticamente">
        <div v-if="errors.has('name')" class="form-control-feedback form-text text-danger font-weight-bold" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<!-- Campo Usuario Registrado -->
<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('user'), 'has-success': fields.user && fields.user.valid }">
    <label for="user" class="col-form-label fw-bold text-dark text-start text-md-start" style="color: #1e293b;" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">
        <i class="fa fa-user-circle-o text-primary me-1"></i> Usuario Sistema
    </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <input readonly type="text" v-model="form.user" @input="validate($event)" class="form-control shadow-sm font-weight-bold text-dark" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #0f172a !important;" id="user" name="user" placeholder="Usuario institucional del solicitante">
        <div v-if="errors.has('user')" class="form-control-feedback form-text text-danger font-weight-bold" v-cloak>@{{ errors.first('user') }}</div>
    </div>
</div>

<!-- Campo ID Dependencia (Oculto) -->
<div style="display: none" class="form-group row align-items-center" :class="{'has-danger': errors.has('dependency_id'), 'has-success': fields.dependency_id && fields.dependency_id.valid }">
    <label for="dependency_id" class="col-form-label text-start text-md-start" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.help.columns.dependency_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <input readonly type="text" v-model="form.dependency_id" @input="validate($event)" class="form-control" id="dependency_id" name="dependency_id">
    </div>
</div>

<!-- Campo Dependencia / Departamento -->
<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('dependency'), 'has-success': fields.dependency && fields.dependency.valid }">
    <label for="dependency" class="col-form-label fw-bold text-dark text-start text-md-start" style="color: #1e293b;" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">
        <i class="fa fa-building text-primary me-1"></i> Dependencia
    </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <input readonly type="text" v-model="form.dependency" @input="validate($event)" class="form-control shadow-sm font-weight-bold text-dark" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #0f172a !important;" id="dependency" name="dependency" placeholder="Dependencia o dirección a la que pertenece">
        <div v-if="errors.has('dependency')" class="form-control-feedback form-text text-danger font-weight-bold" v-cloak>@{{ errors.first('dependency') }}</div>
    </div>
</div>

<!-- Campo Teléfono / Interno -->
<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('fone'), 'has-success': fields.fone && fields.fone.valid }">
    <label for="fone" class="col-form-label fw-bold text-dark text-start text-md-start" style="color: #1e293b;" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">
        <i class="fa fa-phone text-primary me-1"></i> Teléfono / Interno <span class="text-danger">*</span>
    </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.fone" @input="validate($event)" class="form-control shadow-sm font-weight-bold text-dark" style="border: 1px solid #cbd5e1; color: #0f172a;" id="fone" name="fone" placeholder="Nro de interno o teléfono celular para coordinar la atención">
        <div v-if="errors.has('fone')" class="form-control-feedback form-text text-danger font-weight-bold" v-cloak>@{{ errors.first('fone') }}</div>
    </div>
</div>

<!-- Campo Descripción del Problema -->
<div class="form-group row align-items-start mb-3" :class="{'has-danger': errors.has('problem'), 'has-success': fields.problem && fields.problem.valid }">
    <label for="problem" class="col-form-label fw-bold text-dark text-start text-md-start pt-2" style="color: #1e293b;" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">
        <i class="fa fa-pencil-square-o text-primary me-1"></i> Descripción <span class="text-danger">*</span>
    </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <textarea v-model="form.problem" @input="validate($event); form.problem = form.problem.toUpperCase()" class="form-control shadow-sm p-3 font-weight-bold text-dark" style="border: 1px solid #cbd5e1; color: #0f172a;" rows="4" :class="{'form-control-danger': errors.has('problem'), 'form-control-success': fields.problem && fields.problem.valid}" id="problem" name="problem" placeholder="Describa brevemente el inconveniente o la ayuda que requiere (Hardware, Red, Impresora, Accesos, etc.)"></textarea>
        <div v-if="errors.has('problem')" class="form-control-feedback form-text text-danger font-weight-bold" v-cloak>@{{ errors.first('problem') }}</div>
    </div>
</div>

<div class="text-end my-2">
    <small class="text-dark font-weight-bold"><span class="text-danger font-weight-bold">*</span> Campos obligatorios para el registro</small>
</div>

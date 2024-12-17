<div class="form-group row align-items-center" :class="{'has-danger': errors.has('ci'), 'has-success': fields.ci && fields.ci.valid }" v-show="false">
    <label for="ci" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.help.columns.ci') }}(*)</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input @change="findData" v-model="form.ci" @input="validate($event)" class="form-control rounded-pill" :class="{'form-control-danger': errors.has('ci'), 'form-control-success': fields.ci && fields.ci.valid}" id="ci" name="ci" placeholder="NRO DE CEDULA DEL SOLICITANTE">
        <div v-if="errors.has('ci')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ci') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }" v-show="false">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.help.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input readonly v-model="form.name" @input="validate($event)" class="form-control rounded-pill" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.help.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user'), 'has-success': fields.user && fields.user.valid }" v-show="false">
    <label for="user" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.help.columns.user') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input readonly v-model="form.user" @input="validate($event)" class="form-control rounded-pill" :class="{'form-control-danger': errors.has('user'), 'form-control-success': fields.user && fields.user.valid}" id="user" name="user" placeholder="{{ trans('admin.help.columns.user') }}">
        <div v-if="errors.has('user')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('dependency_id'), 'has-success': fields.dependency_id && fields.dependency_id.valid }" v-show="false">
    <label for="dependency_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.help.columns.dependency_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input readonly v-model="form.dependency_id" @input="validate($event)" class="form-control rounded-pill" :class="{'form-control-danger': errors.has('dependency_id'), 'form-control-success': fields.dependency_id && fields.dependency_id.valid}" id="dependency_id" name="dependency_id" placeholder="{{ trans('admin.help.columns.dependency_id') }}">
        <div v-if="errors.has('dependency_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('dependency_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('dependency'), 'has-success': fields.dependency && fields.dependency.valid }" v-show="false">
    <label for="dependency" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.help.columns.dependency') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input readonly v-model="form.dependency" @input="validate($event)" class="form-control rounded-pill" :class="{'form-control-danger': errors.has('dependency'), 'form-control-success': fields.dependency && fields.dependency.valid}" id="dependency" name="dependency" placeholder="{{ trans('admin.help.columns.dependency') }}">
        <div v-if="errors.has('dependency')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('dependency') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('fone'), 'has-success': fields.fone && fields.fone.valid }" v-show="false">
    <label for="fone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.help.columns.fone') }}(*)</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input v-model="form.fone" @input="validate($event)" class="form-control rounded-pill" :class="{'form-control-danger': errors.has('fone'), 'form-control-success': fields.fone && fields.fone.valid}" id="fone" name="fone" placeholder="NRO DE INTERNO O TELEFONO PARTICULAR PARA COORDINAR ASISTENCIA">
        <div v-if="errors.has('fone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('fone') }}</div>
    </div>
</div>

<div v-if="false" class="form-group row align-items-center" :class="{'has-danger': errors.has('problem'), 'has-success': fields.problem && fields.problem.valid }">
    <label for="problem" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.help.columns.problem') }}(*)
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea v-model="form.problem"
                  @input="validate($event); form.problem = form.problem.toUpperCase()"
                  class="form-control"
                  :class="{'form-control-danger': errors.has('problem'), 'form-control-success': fields.problem && fields.problem.valid}"
                  id="problem" name="problem"
                  placeholder="DESCRIBA BREVEMENTE LO QUE SOLICITA O EL INCONVENIENTE QUE PRESENTA">
        </textarea>
        <div v-if="errors.has('problem')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('problem') }}
        </div>
    </div>
</div>


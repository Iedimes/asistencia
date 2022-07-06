<div class="form-group row align-items-center" :class="{'has-danger': errors.has('ci'), 'has-success': fields.ci && fields.ci.valid }">
    <label for="ci" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.functionary.columns.ci') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ci" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ci'), 'form-control-success': fields.ci && fields.ci.valid}" id="ci" name="ci" placeholder="{{ trans('admin.functionary.columns.ci') }}">
        <div v-if="errors.has('ci')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ci') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('full_name'), 'has-success': fields.full_name && fields.full_name.valid }">
    <label for="full_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.functionary.columns.full_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.full_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('full_name'), 'form-control-success': fields.full_name && fields.full_name.valid}" id="full_name" name="full_name" placeholder="{{ trans('admin.functionary.columns.full_name') }}">
        <div v-if="errors.has('full_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('full_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_name'), 'has-success': fields.user_name && fields.user_name.valid }">
    <label for="user_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.functionary.columns.user_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_name'), 'form-control-success': fields.user_name && fields.user_name.valid}" id="user_name" name="user_name" placeholder="{{ trans('admin.functionary.columns.user_name') }}">
        <div v-if="errors.has('user_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_name') }}</div>
    </div>
</div>



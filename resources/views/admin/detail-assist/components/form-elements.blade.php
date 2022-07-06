<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_assist'), 'has-success': fields.id_assist && fields.id_assist.valid }">
    <label for="id_assist" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-assist.columns.id_assist') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_assist" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_assist'), 'form-control-success': fields.id_assist && fields.id_assist.valid}" id="id_assist" name="id_assist" placeholder="{{ trans('admin.detail-assist.columns.id_assist') }}">
        <div v-if="errors.has('id_assist')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_assist') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_user'), 'has-success': fields.id_user && fields.id_user.valid }">
    <label for="id_user" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-assist.columns.id_user') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_user" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_user'), 'form-control-success': fields.id_user && fields.id_user.valid}" id="id_user" name="id_user" placeholder="{{ trans('admin.detail-assist.columns.id_user') }}">
        <div v-if="errors.has('id_user')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_user') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_state'), 'has-success': fields.id_state && fields.id_state.valid }">
    <label for="id_state" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-assist.columns.id_state') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_state" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_state'), 'form-control-success': fields.id_state && fields.id_state.valid}" id="id_state" name="id_state" placeholder="{{ trans('admin.detail-assist.columns.id_state') }}">
        <div v-if="errors.has('id_state')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_state') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('solution'), 'has-success': fields.solution && fields.solution.valid }">
    <label for="solution" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-assist.columns.solution') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.solution" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('solution'), 'form-control-success': fields.solution && fields.solution.valid}" id="solution" name="solution" placeholder="{{ trans('admin.detail-assist.columns.solution') }}">
        <div v-if="errors.has('solution')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('solution') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-assist.columns.date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date'), 'form-control-success': fields.date && fields.date.valid}" id="date" name="date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>


